<?

	// Инициализация

	require_once "../_base/DALC.php";
	require_once "../_base/Product_DALC.php";

	require('./request.php');

	$request = new Request(array('restful' => true));

	$data = $request->params->data;

	$dalc = new DALC();
 
	$dalc->SQL_UpdateItems( 'products', array( array( 'id' => $data->id, 'price' => $data->price )), array('price') );

	$product_dalc = new Product_DALC();

	$product = $product_dalc->GetProduct( $data->id );

	echo json_encode(Array(
	    'success' => 'true',
	    'data'    => array(
			'id'    => $product['id'],
			'label' => $product['label'],
			'price' => $product['price']
		)
	));

?>