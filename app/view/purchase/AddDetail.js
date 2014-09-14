Ext.define('POS.view.purchase.AddDetail' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.add-purchase-detail',
    id: 'add-purchase-detail',
    controller: 'add-purchase-detail',
    viewModel: {
        type: 'add-purchase-detail'
    },

    requires: [
        'POS.custom.field.ComboProduct',
        'POS.custom.field.ComboStockVariant',
        'POS.custom.field.StockAmount',
        'POS.custom.field.Price',
        'POS.tpl.PriceStatus',
        'POS.tpl.StockDetail',
        'POS.view.purchase.AddDetailController',
        'POS.view.purchase.AddDetailModel',
        'POS.view.stock.AddVariant'
    ],

	autoScroll: true,
    autoShow: true,
    bodyStyle: {
        'background-color': '#e9eaed',
        border: '0 !important',
        padding: '25px'
    },
    cls: 'window',
    constrain: true,
    layout: 'anchor',
    maximized: true,
    modal: true,
    resizable: false,

    initComponent: function(){
        this.title = '<i class="fa fa-truck glyph"></i> Tambahkan Produk yang Dibeli';

        this.items = [{
            xtype: 'form',
            reference: 'form',
            layout: 'anchor',
            bodyStyle: {
                'background-color': '#e9eaed'
            },
            monitorValid: true,
            style: {
                margin: '0 auto'
            },
            width: 900,
            items: [{
                xtype: 'container',
                layout: 'anchor',
                cls: 'panel',
                margin: '0 0 10 0',
                padding: 30,
                anchor: '100%',
                items: [{
                    xtype: 'container',
                    anchor: '100%',
                    layout: 'hbox',
                    margin: '0 0 10 0',
                    items:[{
                        xtype: 'combo-product',
                        fieldLabel: 'Produk',
                        name: 'product',
                        reference: 'product',
                        afterLabelTextTpl: REQUIRED,
                        allowBlank: false,
                        width: 300,
                        listeners: {
                            'change': 'onProductChange',
                            'clear': 'onProductClear',
                            'select': 'onProductSelect'
                        }
                    },{
                        xtype: 'combo-stock-variant',
                        fieldLabel: 'Stock Variant',
                        name: 'stock',
                        reference: 'stock',
                        afterLabelTextTpl: REQUIRED,
                        allowBlank: false,
                        margin: '0 0 0 20',
                        width: 200,
                        listeners: {
                            'clear': 'onStockClear',
                            'select': 'onStockSelect',
                            'setvalue': 'onStockSetValue'
                        }
                    },{
                        xtype: 'label',
                        html: 'atau',
                        margin: '30 0 0 10'
                    },{
                        xtype: 'button',
                        text: 'Tambah Variant',
                        reference: 'add_variant',
                        handler: 'addVariant',
                        margin: '25 0 0 10'
                    }]
                },{
                    xtype: 'container',
                    anchor: '100%',
                    layout: 'hbox',
                    margin: '0 0 10 0',
                    items:[{
                        xtype: 'field-stock-amount',
                        fieldLabel: 'Jumlah',
                        name: 'amount',
                        reference: 'amount',
                        afterLabelTextTpl: REQUIRED,
                        allowBlank: false,
                        step: 1,
                        tabOnEnter: true,
                        minValue: 1,
                        value: 1,
                        width: 75,
                        listeners: {
                            'change': 'setUnitPrice'
                        }
                    },{
                        xtype: 'label',
                        reference: 'unit',
                        html: 'unit',
                        margin: '30 0 0 10'
                    },{
                        xtype: 'field-price',
                        fieldLabel: 'Total Harga',
                        name: 'total_price',
                        reference: 'total_price',
                        afterLabelTextTpl: REQUIRED,
                        allowBlank: false,
                        saveOnEnter: true,
                        margin: '0 0 0 50',
                        width: 150,
                        listeners: {
                            'change': 'setUnitPrice'
                        }
                    },{
                        xtype: 'container',
                        html: 'Harga satuan : ',
                        margin: '30 0 0 50'
                    },{
                        xtype: 'container',
                        reference: 'unit_price',
                        html: '-',
                        margin: '30 0 0 10'
                    },{
                        xtype: 'container',
                        reference: 'price_status',
                        tpl: Ext.create('POS.tpl.PriceStatus'),
                        margin: '28 0 0 40'
                    }]
                }]
            },{
                xtype: 'toolbar',
                ui: 'footer',
                margin: '0 0 30 0',
                width: 900,
                items: ['->',
                {
                    text: '<i class="fa fa-save glyph"></i> Simpan',
                    handler: 'save'
                },{
                    text: '<i class="fa fa-undo glyph"></i> Batal',
                    handler: 'close'
                }]
            },{
                xtype: 'container',
                reference: 'detail_container',
                cls: 'panel',
                hidden: true,
                width: 900,
                items: [{
                    xtype: 'container',
                    html: 'Informasi Stock',
                    cls: 'panel-header'
                },{
                    xtype: 'container',
                    reference: 'detail_panel',
                    tpl: Ext.create('POS.tpl.StockDetail'),
                    padding: 10,
                    anchor: '100%',
                    minHeight: 100,
                    bind: {
                        data: '{stock}'
                    }
                }]
            }]
        }];

        this.callParent(arguments);
    }
});