//--------------------------------------------------------------------------------------------------
// Панель

var tabs = {};

//--------------------------------------------------------------------------------------------------
// Панель вкладки "Заказ"

var tab_info = {};

tab_info.onDelete = function () {

 	Ext.Msg.confirm (
	 	'Удаление записи',
		'Вы действительно хотите удалить эту запись?',
		function(btn, text) {
			if (btn == 'yes'){
			    Ext.Ajax.request(
					{
			        	url: 'app/Orders/delete.php',
			        	method: 'POST',
			        	params: {
							'ids': request_param_id
						},
			        	success: function(obj) {
							location.href = 'orders.php?noframe=1';
				        },
						failure: function(){
							Ext.MessageBox.alert('Failed', 'Произошла системная ошибка');
							location.href = 'orders.php?noframe=1';
						}
					}
				);
			}
		}
	);

};

tab_info.onSave = function () {

 	Ext.Msg.confirm (
	 	'Сохранение',
		'Вы действительно хотите сохранить изменения?',
		function(btn, text) {

			if (btn == 'yes') {

			    Ext.Msg.show ({
					title: 'Ждите...',
					msg: 'Сохранение данных',
					width: 150,
					icon: 'ext-mb-info',
					closable: false
				});

				tab_info.form.getForm().submit();

				Ext.Msg.hide();

			}
		}
	);

};

tab_info.form = Ext.create(
	'Ext.form.Panel',
	{
		layout: {
			type: 'border'
		},

		title: 'My Form',

		bodyPadding: 10,
		hideCollapseTool: false,
		preventHeader: true,
		region: 'center',

		border: false,

		url: 'app/Orders/save.php',

		items: [
            {
                xtype: 'fieldset',
                title: 'Описание',
                region: 'north',
                items: [
                	{
						xtype: 'hiddenfield',
						name: 'id',
						value: request_param_id
					},
                    {
                        fieldLabel: 'Заказчик',
						name: 'fio',
						xtype: 'textfield',
                        width: 400
                    },
					{
                        fieldLabel: 'E-Mail',
						name: 'email',
						xtype: 'textfield',
                        width: 400
                    },
					{
                        fieldLabel: 'Телефон',
                        name: 'phone',
						xtype: 'textfield',
                        width: 250
                    },
					{
                        fieldLabel: 'Оформлен',
						name: 'dt',
                        xtype: 'datefield',
                        format: 'd.m.Y',
                        altFormats: 'Y-m-d H:i:s',
                        width: 200
                    }
                ]
            },
            {
				xtype: 'fieldset',
                title: 'Доставка',
                region: 'center',
                items: [
                	{
                        fieldLabel: 'Способ',
						name: 'shipping_method',
						xtype: 'textfield',
                        width: 400,
                        readOnly: true
					},
                    {
                        fieldLabel: 'Параметры',
						name: 'shipping_params',
						xtype: 'textareafield',
                        height: 100,
                        anchor: '100%',
                        readOnly: true
                    },
					{
                        fieldLabel: 'Страна',
						name: 'country',
						xtype: 'textfield',
                        width: 400,
                        readOnly: true
                    },
					{
                        fieldLabel: 'Регион',
                        name: 'country_region',
						xtype: 'textfield',
                        width: 400,
                        readOnly: true
                    },
                    {
                        fieldLabel: 'Адрес',
						name: 'shipping_address',
						xtype: 'textareafield',
                        height: 100,
                        anchor: '100%',
                        readOnly: true
                    },
					{
                        fieldLabel: 'Стоимость',
						name: 'shipping_cost',
						xtype: 'numberfield',
                        maxValue: 100000,
                        minValue: 0,
                        width: 200,
                        readOnly: true
                    }
                ]
			}
		],

		dockedItems: [
			{
				xtype: 'toolbar',
				width: 150,
				region: 'west',
				dock: 'bottom',
		        items: [
					{
						xtype: 'button',
						text: 'Сохранить',
						handler: tab_info.onSave
					},
					{
						xtype: 'button',
						text: 'Удалить',
						handler: tab_info.onDelete
					}
				]
			}
		]
	}
);

tab_info.form.load(
	{
		url: 'app/Orders/form.php',
		params: {
			'id': request_param_id
		},
		callback: function(){
			//
		},
		success: function(){
			//
		},
		failure: function(){
			//
		}
	}
);

tab_info.panel = Ext.create(
	'Ext.panel.Panel',
	{
		layout: {
			type: 'border'
		},
		title: 'Заказ',

		border: false,

		tabConfig: {
			xtype: 'tab',
			region: 'west'
		},
		items: [
			tab_info.form
		]
	}
);

//--------------------------------------------------------------------------------------------------
// Панель вкладки "Состав заказа"

var tab_order_items = {};

tab_order_items.grid = {};

tab_order_items.grid.model = Ext.define (
	'tab_order_items.grid.model',
	{
	    extend: 'Ext.data.Model',
	    idProperty: 'id',
	    fields: [
			{
				name: 'id'
			},
			{
				name: 'id_product'
			},
			{
				name: 'articul'
			},
			{
				name: 'label'
			},
			{
				name: 'price'
			},
			{
				name: 'qty'
			},
			{
				name: 'size'
			},
			{
				name: 'subtotal'
			}
	    ]
	}
);

tab_order_items.grid.store = Ext.create(
	'Ext.data.Store',
	{
	    proxy: {
	        type: 'ajax',
	        url: 'app/Orders/select_order_items.php',
			reader: {
				type: 'json',
				root: 'items',
				totalProperty: 'totalCount'
			},
			extraParams: {
				id_order: request_param_id + 0,
			}
	    },

		model: tab_order_items.grid.model,

		autoLoad: true
	}
);

tab_order_items.grid.panel = Ext.create(
	'Ext.grid.Panel',
	{
		store: tab_order_items.grid.store,

		preventHeader: true,

		forceFit: true,
		region: 'center',
		border: false,

		columns: [
			{
				xtype: 'numbercolumn',
				width: 40,
				align: 'right',
				dataIndex: 'id',
				text: '#',
				format: '0'
			},
			{
				xtype: 'gridcolumn',
				width: 80,
				dataIndex: 'articul',
				fixed: false,
				text: 'Артикул'
			},
			{
				xtype: 'gridcolumn',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
					var id_product = record.get('id_product');
					if ( id_product == 0 ) {
						return record.get('label');
					} else {
						return '<a href="products.php?noframe=1&id=' + record.get('id_product') + '">' +
							record.get('label') +
							'</a><p style="padding: 4 0 0 0;">Размер: ' +
							record.get('size') +
							'</p>';
					}
				},
				text: 'Наименование'
			},
			{
				xtype: 'numbercolumn',
				width: 100,
				align: 'right',
				dataIndex: 'price',
				text: 'Цена'
			},
			{
				xtype: 'numbercolumn',
				width: 100,
				align: 'right',
				dataIndex: 'qty',
				text: 'Кол-во'
			},
			{
				xtype: 'numbercolumn',
				width: 100,
				align: 'right',
				dataIndex: 'subtotal',
				text: 'Сумма'
			}			
		],

		dockedItems: [
		    {
		        xtype: 'pagingtoolbar',
		        store: tab_order_items.grid.store,
		        displayInfo: true,
		        dock: 'bottom'
		    },
		    {
		        xtype: 'toolbar',
		        dock: 'top',
		        items: [
		            {
		                xtype: 'button',
		                text: 'Добавить'
		            },
		            {
		                xtype: 'button',
		                text: 'Удалить'
		            }
		        ]
		    }
		],

		selModel: Ext.create(
			'Ext.selection.CheckboxModel',
			{}
		),

		plugins: [
		    Ext.create(
				'Ext.grid.plugin.CellEditing',
				{
		        	ptype: 'cellediting'
		    	}
			)
		]
	}
);

tab_order_items.panel = Ext.create(
	'Ext.panel.Panel',
	{
		layout: {
			type: 'border'
		},

		title: 'Состав заказа',

		border: false,

		tabConfig: {
			xtype: 'tab',
			width: 150,
			region: 'west'
		},

		items: [
			tab_order_items.grid.panel
		]
	}
);

//--------------------------------------------------------------------------------------------------
// Панель вкладки "Состав заказа"

var tab_robokassa = {};

tab_robokassa.onGetPaymentURL = function () {

    Ext.Ajax.request(
		{
        	url: 'app/Robokassa.php',
        	method: 'POST',
        	params: {
				'id_order': request_param_id,
				'score': tab_robokassa.form.getForm().findField('score').getValue()
			},
        	success: function(response) {
        		var obj = Ext.decode(response.responseText);
				tab_robokassa.form.getForm().findField('url').setValue(obj.url);
	        },
			failure: function(){
				alert('Произошла ошибка');
				tab_robokassa.form.getForm().findField('url').setValue('');
			}
		}
	);

};

tab_robokassa.form = Ext.create(
	'Ext.form.Panel',
	{
		layout: {
			type: 'border'
		},

		title: 'My Form',

		bodyPadding: 10,
		hideCollapseTool: false,
		preventHeader: true,
		region: 'center',

		border: false,

		items: [
            {
                xtype: 'fieldset',
                title: 'Оплата',
                region: 'center',
                items: [
                    {
                        fieldLabel: 'Сумма',
						name: 'score',
						xtype: 'numberfield',
                        maxValue: 100000,
                        minValue: 0,
                        width: 200//,
                        //readOnly: true
                    },
                    {
						xtype: 'button',
						text: 'Получить ссылку',
						margin: '0 0 20 105',
						handler: tab_robokassa.onGetPaymentURL
					},
                    {
                        fieldLabel: 'Ссылка',
						name: 'url',
						xtype: 'textareafield',
                        height: 100,
                        anchor: '100%',
                        readOnly: true
                    }
                ]
            }
		],
	}
);

tab_robokassa.form.load(
	{
		url: 'app/Orders/get_owing.php',
		params: {
			'id_order': request_param_id
		},
		callback: function(){
			//
		},
		success: function(){
			//
		},
		failure: function(){
			//
		}
	}
);

tab_robokassa.panel = Ext.create(
	'Ext.panel.Panel',
	{
		layout: {
			type: 'border'
		},
		title: 'Robokassa',

		border: false,

		tabConfig: {
			xtype: 'tab',
			region: 'west'
		},
		items: [
			tab_robokassa.form
		]
	}
);

//--------------------------------------------------------------------------------------------------
// 

tabs.panel = Ext.create(
	'Ext.tab.Panel',
	{
		activeTab: 0,
		region: 'center',

		layout: {
			type: 'border'
		},

		items: [
			tab_info.panel,
			tab_order_items.panel,
			tab_robokassa.panel
		]
	}
);
