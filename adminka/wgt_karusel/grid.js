
var grid = {};

//--------------------------------------------------------------------------------------------------
// Модель данных

grid.model = Ext.define (
	'grid.model',
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
				name: 'in_stock'
			},
			{
				name: 'articul'
			},
			{
				name: 'label'
			},
			{
				name: 'category'
			},
			{
				name: 'id_category'
			},
			{
				name: 'price'
			}
	    ]
	}
);

//--------------------------------------------------------------------------------------------------
// Источник данных

grid.store = Ext.create(
	'Ext.data.Store',
	{
	    proxy: {
	        type: 'ajax',
	        url: 'app/WidgetKarusel/grid.php',
			reader: {
				type: 'json',
				root: 'items',
				totalProperty: 'totalCount'
			}
	    },

		model: grid.model,

		autoLoad: true
	}
);

//--------------------------------------------------------------------------------------------------
// Панель

grid.panel = Ext.create(
	'Ext.grid.Panel',
	{
		store: grid.store,

		preventHeader: true,

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
				renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
					return record.get('in_stock') == 1 ? '<span style="color:Green;">да</span>' : '<span style="color:#AAAAAA;">нет</span>';
				},
				text: 'В продаже'
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
				dataIndex: 'label',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
					return '<a href="products.php?noframe=1&id=' + record.get('id') + '">' + record.get('label') + '</a>';
				},
				text: 'Наименование'
			},
			{
				xtype: 'gridcolumn',
				dataIndex: 'category',
				renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
					return '<a href="product_categories.php?noframe=1&id=' + record.get('id_category') + '">' + record.get('category') + '</a>';
				},
				text: 'Категория'
			},
			{
				xtype: 'numbercolumn',
				width: 100,
				align: 'right',
				dataIndex: 'price',
				text: 'Цена'
			}
		],
		dockedItems: [
			{
				xtype: 'pagingtoolbar',
				displayInfo: true,
				store: grid.store,
				dock: 'bottom'
			}
		],
		selModel: Ext.create('Ext.selection.CheckboxModel', {
			
		})
	}
);
