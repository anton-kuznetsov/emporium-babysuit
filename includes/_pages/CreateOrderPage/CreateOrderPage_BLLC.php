<?php

class CreateOrderPage_BLLC {

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/_pages/CreateOrderPage/';

	}

	//--------------------------------------------------------------------------
	//

	public function NewOrder( $data ) {

		$cart_dalc = new Cart_DALC();

		$cart = $cart_dalc->GetCartBySession( session_id() );

		$cart_items = $cart_dalc->GetCartItems( $cart['id'] );

		$order = null;

		if ( $cart['id_order'] == 0 ) {

			$order = $cart_dalc->SQL_CreateItem( 
				'orders',
				array(
					'id_shipping_method' => $data['id_shipping_method'],
					'shipping_params'    => $data['shipping_params'],
					'status'             => 1,
					'shipping_cost'      => Shipping::Calc( 
						$data['id_shipping_method'],
						$data['shipping_params'],
						$cart_items
					),
					'id_country' => 1,
				)
			);

			$cart['id_order'] = $order['id'];

			// Сохраняю связь между корзиной и черновиком заказа
	
			$cart_dalc->SQL_UpdateItems(
				'cart',
				array( $cart ),
				array( 'id_order' )
			);

		} else {

			$order_dalc = new Order_DALC();

			$order = $order_dalc->GetOrder( $cart['id_order'] );

			# Поновой сохраняю данные по доставке

			$order['id_shipping_method'] = $data['id_shipping_method'];
			$order['shipping_params']    = $data['shipping_params'];
			$order['shipping_cost']      = Shipping::Calc( $data['id_shipping_method'], $data['shipping_params'], $cart_items );

			$order_dalc->SQL_UpdateItems(
				'orders',
				array( $order ),
				array( 'id_shipping_method', 'shipping_params', 'shipping_cost' )
			);

		}

		//

		header("Location: " . CreateOrder_UI::href( array( 'action' => 'step1', 'id_order' => $cart['id_order'] ), 1));
		exit;

	}

	//--------------------------------------------------------------------------
	//

	public function SetContactsToOrder( $data ) {

		$order_dalc = new Order_DALC();

		$order = $order_dalc->GetOrder( $data['id_order'] );

		# Поновой сохраняю контактные данные

		$order['fio']               = $data['fio'];
		$order['email']             = $data['email'];
		$order['phone']             = $data['phone'];
		$order['id_country']        = $data['id_country'];
		$order['id_country_region'] = $data['id_country_region'];
		$order['shipping_address']  = $data['shipping_address'];

		$order_dalc->SQL_UpdateItems(
			'orders',
			array( $order ),
			array( 'fio', 'email', 'phone', 'id_country', 'id_country_region', 'shipping_address' )
		);

		//

		header("Location: " . CreateOrder_UI::href( array( 'action' => 'step2', 'id_order' => $order['id'] ), 1));
		exit;

	}

	//--------------------------------------------------------------------------
	//

	public function DoneOrder( $data ) {

		$order_dalc = new Order_DALC();

		$product_page_bllc = new ProductPage_BLLC();

		$cart_dalc = new Cart_DALC();

		$cart = $cart_dalc->GetCartBySession( session_id() );

		//

		$cart_items = $cart_dalc->GetCartItems( $cart['id'] );

		foreach ( $cart_items as $cart_item ) {

			$item = array ();

			$item['id_product'] = $cart_item['id_product'];
			$item['price']      = $cart_item['price'];
			$item['qty']        = $cart_item['qty'];
			$item['size']       = $cart_item['size'];
			$item['id_order']   = $data['id_order'];

			$order_dalc->CreateOrderItem( $item );

			$product_page_bllc->CountingBuy( $cart_item['id_product'] );

		}

		//

		$cart_dalc->SQL_DeleteItems( 'cart_items', ' id_cart = ' . $cart['id'] );

		$cart['id_order'] = 0;

		$cart_dalc->SQL_UpdateItems(
			'cart',
			array( $cart ),
			array( 'id_order' )
		);

		//

		$order = $order_dalc->GetOrder( $data['id_order'] );

		$order['status'] = 2;

		$order_dalc->SQL_UpdateItems(
			'orders',
			array( $order ),
			array( 'status' )
		);

		// Посылаю письма

		$this->SendToClient( $data['id_order'] );

		$this->SendToManager( $data['id_order'] );

		//

		header("Location: " . CreateOrder_UI::href( array( 'action' => 'step3', 'id_order' => $data['id_order'] ), 1));
		exit;

	}

	//--------------------------------------------------------------------------
	//

	public function SendToClient( $id_order ) {

		$create_order_bllc = new CreateOrder_BLLC();

		$data = $create_order_bllc->GetData( $id_order );

		//

		$to  = $data['email'];

		// тема письма

		$subject = 'Ваш заказ № ' . $id_order;

		// текст письма

		$message = 
			'<html><head><title>' . $subject . '</title></head>
		  	<body>
			  	<p>
					Номер заказа: ' . $id_order . '<br />
					Дата: ' . $data['dt_str'] . '
				</p>
				<p>
					<b>Заказчик</b><br />
					ФИО: ' . $data['fio'] . '<br />
					E-mail: ' . $data['email'] . '<br />
					Телефон: ' . $data['phone'] . '
				</p>
				<table id="order-table" style="width: 100%;" border="1" cellpadding="0" cellspacing="0">
					<col width="1" />
					<col />
					<col width="1" />
					<col width="1" />
					<col width="1" />
					<thead>
						<tr>
							<th rowspan="1" style="text-align: center; padding: 4px;"><span style="white-space: nowrap; ">№</span></th>
							<th rowspan="1" style="padding: 4px;"><span style="white-space: nowrap; ">Наименование</span></th>
							<th colspan="1" style="text-align: center; padding: 4px;"><span style="white-space: nowrap; ">Цена</span></th>
							<th rowspan="1" style="text-align: center; padding: 4px;"><span style="white-space: nowrap; ">Кол-во</span></th>
							<th colspan="1" style="text-align: center; padding: 4px;"><span style="white-space: nowrap; ">Сумма</span></th>
						</tr>
					</thead>
					<tbody>';

		$i = 0;

		foreach ( $data['order_items'] as $item ) {

			$i++;

			$message .= 
						'<tr>
							<td style="text-align: center; padding: 4px;">
								' . $i . '
							</td>
							<td style="padding: 4px;">
								<b>' . $item['articul'] . '</b> ' . $item['label'] . '<br />Размер: ' . $item['size'] . '
							</td>
							<td style="text-align: right; padding: 4px;">
								<span style="white-space: nowrap; ">' . $item['price_str'] . '</span>
							</td>
							<td style="text-align: center; padding: 4px;">
								' . $item['qty'] . '
							</td>
							<td style="text-align: right; padding: 4px;">
								<span style="white-space: nowrap; ">' . $item['subtotal_str'] . '</span>
							</td>
						</tr>';

		}

		$message .=
					'</tbody>
				</table>
				<br />
				<p>
					<b>Доставка</b><br />
					Способ: ' . $data['shipping_method']['label'] . '<br />
					Адрес: ' . $data['country']['label'] . ', ' . $data['country_region']['label'] . '<br />' . $data['shipping_address'] . '
				</p>
				<p>
					<b>Стоимость</b><br />
					Товар: <b>' . $data['products_cost_str'] . '</b>
					Доставка: <b>' . $data['shipping_cost_str'] . '</b>
					Сумма заказа: <b>' . $data['total_str'] . '</b>
				</p>
				<p>
					<b>Менеджер по работе с клиентами</b><br />
					Имя: ' . $data['client_manager']['fio'] . '<br />
					Телефон: ' . $data['client_manager']['phone'] . '
				</p>
			</body></html>';

		// Для отправки HTML-письма должен быть установлен заголовок Content-type
		$headers  = 'MIME-Version: 1.0' . "\r\n";
// 		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

		// Дополнительные заголовки
		$headers .= 'To: <' . $data['email'] . '>' . "\r\n";
		$headers .= 'From: BabySuit.Ru <no-reply@babysuit.ru>' . "\r\n";
		$headers .= 'Cc: ' . "\r\n";
		$headers .= 'Bcc: ' . "\r\n";
	
		// Отправляем
		$subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
		
		mail($to, $subject, $message, $headers);

	}

	//--------------------------------------------------------------------------
	//

	public function SendToManager( $id_order ) {

		$create_order_bllc = new CreateOrder_BLLC();

		$data = $create_order_bllc->GetData( $id_order );

		//

		$to  = $data['client_manager']['email'];

		// тема письма

		$subject = 'Заказ № ' . $id_order;

		// текст письма

		$message = 
			'<html><head><title>' . $subject . '</title></head>'.
		  	'<body>
			  	<p>
					Номер заказа: ' . $id_order . '<br />
					Дата: ' . $data['dt_str'] . '
				</p>
				<p>
					<b>Заказчик</b><br />
					ФИО: ' . $data['fio'] . '<br />
					E-mail: ' . $data['email'] . '<br />
					Телефон: ' . $data['phone'] . '
				</p>
				<table id="order-table" style="width: 100%;" border="1" cellpadding="0" cellspacing="0">
					<col width="1" />
					<col />
					<col width="1" />
					<col width="1" />
					<col width="1" />
					<thead>
						<tr>
							<th rowspan="1" style="text-align: center; padding: 4px;"><span style="white-space: nowrap; ">№</span></th>
							<th rowspan="1" style="padding: 4px;"><span style="white-space: nowrap; ">Наименование</span></th>
							<th colspan="1" style="text-align: center; padding: 4px;"><span style="white-space: nowrap; ">Цена</span></th>
							<th rowspan="1" style="text-align: center; padding: 4px;"><span style="white-space: nowrap; ">Кол-во</span></th>
							<th colspan="1" style="text-align: center; padding: 4px;"><span style="white-space: nowrap; ">Сумма</span></th>
						</tr>
					</thead>
					<tbody>';

		$i = 0;

		foreach ( $data['order_items'] as $item ) {

			$i++;

			$message .= 
						'<tr>
							<td style="text-align: center; padding: 4px;">
								' . $i . '
							</td>
							<td style="padding: 4px;">
								<b>' . $item['articul'] . '<b/> ' . $item['label'] . ', Размер: ' . $item['size'] . '
							</td>
							<td style="text-align: right; padding: 4px;">
								<span style="white-space: nowrap; ">' . $item['price_str'] . '</span>
							</td>
							<td style="text-align: center; padding: 4px;">
								' . $item['qty'] . '
							</td>
							<td style="text-align: right; padding: 4px;">
								<span style="white-space: nowrap; ">' . $item['subtotal_str'] . '</span>
							</td>
						</tr>';

		}

		$message .=
					'</tbody>
				</table>
				<br />
				<p>
					<b>Доставка</b><br />
					Способ: ' . $data['shipping_method']['label'] . '<br />
					Адрес: ' . $data['country']['label'] . ', ' . $data['country_region']['label'] . '<br />' . $data['shipping_address'] . '
				</p>
				<p>
					<b>Стоимость</b><br />
					Товар: <b>' . $data['products_cost_str'] . '</b>
					Доставка: <b>' . $data['shipping_cost_str'] . '</b>
					Сумма заказа: <b>' . $data['total_str'] . '</b>
				</p>
			</body></html>';

		// Для отправки HTML-письма должен быть установлен заголовок Content-type
		$headers  = 'MIME-Version: 1.0' . "\r\n";
// 		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

		// Дополнительные заголовки
		$headers .= 'To: <' . $data['client_manager']['email'] . '>' . "\r\n";
		$headers .= 'From: BabySuit.Ru <no-reply@babysuit.ru>' . "\r\n";
		$headers .= 'Cc: ' . "\r\n";
		$headers .= 'Bcc: ' . "\r\n";

		// Отправляем
		$subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";

		mail($to, $subject, $message, $headers);

	}

};

?>