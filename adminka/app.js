
// Ext.Loader.setConfig({enabled:true});

// Подгружаю классы, которые буду использовать

Ext.require('Ext.container.Viewport');

// Приложение

Ext.application({
	name: 'Baby-Suit.Ru :: Управление данными',
	launch: function() {

    	var cw;

//**************************************************************************************************
// Дерево навигации (menu_tree.js)
//  - menu_tree
//      - menu_tree.model
//      - menu_tree.store
//      - menu_tree.panel
//**************************************************************************************************

//******************************************************************************
// Таблица Товаров
//******************************************************************************

	Ext.QuickTips.init();

	Ext.define('Product', {
	    extend: 'Ext.data.Model',
	    fields: [
			{
		        name: 'id',
		        type: 'int'
	    	},
			{
	        	name: 'label'
	    	},
			{
		        name: 'price',
		        type: 'float'
	    	}
		]
	});

	var store_grid_products = Ext.create('Ext.data.ArrayStore', {
		model: 'Product',
		autoLoad: true,
        autoSync: true,
		proxy: {
	        type: 'ajax',
            api: {
                read:    'app/Products/data_for_grid.php',
                create:  'app/Products/insert.php',
                update:  'app/Products/update.php',
                destroy: 'app/Products/delete.php'
            },
            reader: {
                type: 'json',
                root: 'data',
                idProperty: 'id',
                totalProperty: 'total'
            },
            writer: {
                type: 'json',
                root: 'data',
                writeAllFields: false
            }
        },
		remoteSort: false,
        sorters: [{
            property: 'id',
            direction: 'ASC'
        }],
        baseParams : {
            id_brand: 6
        },
        pageSize: 35
	});

	var cell_editing_grid_products = Ext.create('Ext.grid.plugin.CellEditing', {
        clicksToEdit: 1
    });

    var grid_products = Ext.create('Ext.grid.Panel', {
        store: store_grid_products,
        stateful: true,
        stateId: 'stateGrid',
        columns: [
            {
                text     : 'Id',
                width    : 50,
                sortable : true,
                dataIndex: 'id'
            },
            {
                text     : 'Наименование',
                flex     : 1,
                sortable : true,
                dataIndex: 'label'
            },
            {
                text     : 'Цена',
                sortable : true,
                dataIndex: 'price',
                editor   : {
	                xtype: 'numberfield',
	                allowBlank: false,
	                minValue: 0,
	                maxValue: 1000000
	            }
            }
        ],
		height: '100%',
		width: '100%',
        title: 'Товары',
        bbar: Ext.create('Ext.PagingToolbar', {
            store: store_grid_products,
            displayInfo: true,
            displayMsg: 'Записи с {0} по {1} из {2}',
            emptyMsg: "Нет записей"
        }),
        viewConfig: {
            stripeRows: true
        },
        plugins: [
			cell_editing_grid_products
		]
    });

//******************************************************************************
// Таблица Категорий
//******************************************************************************

	Ext.QuickTips.init();

	// model для таблицы "Категории"

	Ext.define('Category', {
	    extend: 'Ext.data.Model',
	    fields: [
			{
		        name: 'id',
		        type: 'int'
	    	},
			{
	        	name: 'label'
	    	},
	    	{
		        name: 'level',
		        type: 'int'
	    	}
		]
	});

	var store_grid_categories = Ext.create('Ext.data.ArrayStore', {
		model: 'Category',
		autoLoad: true,
        autoSync: true,
		proxy: {
	        type: 'ajax',
            api: {
                read:    'app/Categories/data_for_grid.php',
                create:  'app/Categories/insert.php',
                update:  'app/Categories/update.php',
                destroy: 'app/Categories/delete.php'
            },
            reader: {
                type: 'json',
                root: 'data',
                idProperty: 'id',
                totalProperty: 'total'
            },
            writer: {
                type: 'json',
                root: 'data',
                writeAllFields: false
            }
        },
		remoteSort: false,
        sorters: [{
            property: 'id',
            direction: 'ASC'
        }],
        pageSize: 35
	});

	// Редактор ячейки таблицы

	var cell_editing_grid_categories = Ext.create('Ext.grid.plugin.CellEditing', {
        clicksToEdit: 1
    });

	//

    var grid_categories = Ext.create('Ext.grid.Panel', {
        store: store_grid_categories,
        stateful: true,
        stateId: 'stateGrid',
        columns: [
            {
                text     : 'Id',
                width    : 50,
                sortable : true,
                dataIndex: 'id'
            },
            {
                text     : 'Наименование',
                flex     : 1,
                sortable : true,
                dataIndex: 'label'
            }
        ],
		height: '100%',
		width: '100%',
        title: 'Категории товаров',
        bbar: Ext.create('Ext.PagingToolbar', {
            store: store_grid_categories,
            displayInfo: true,
            displayMsg: 'Записи с {0} по {1} из {2}',
            emptyMsg: "Нет записей"
        }),
        viewConfig: {
            stripeRows: true
        },
        plugins: [
			cell_editing_grid_categories
		]
    });

//******************************************************************************
// Каркас экрана
//******************************************************************************

    	Ext.create('Ext.Viewport', {
	        layout: {
	            type: 'border',
	            padding: 5
	        },
	        items: [

				// Правая часть

				menu_tree.panel,

				// Центр

				{
					xtype: 'panel',
					id: 'frame_panel',
					itemId: 'frame_panel',
					region: 'center',
					padding: '0 0 0 5px',
					border: false
				},
			]
	    });

	}
});