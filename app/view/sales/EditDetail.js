Ext.define('POS.view.sales.EditDetail' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.edit-sales-detail',
    id: 'edit-sales-detail',
    controller: 'edit-sales-detail',
    viewModel: {
        type: 'edit-sales-detail'
    },

    requires: [
        'POS.custom.field.ComboStock',
        'POS.custom.field.StockAmount',
        'POS.custom.field.ComboSellType',
        'POS.custom.field.Price',
        'POS.view.sales.EditDetailController',
        'POS.view.sales.EditDetailModel'
    ],

	autoScroll: true,
    autoShow: true,
    bodyStyle: {
        'background-color': '#e9eaed',
        border: '0 !important',
        pediting: '25px'
    },
    constrain: true,
    layout: 'anchor',
    maximized: true,
    resizable: false,

    initComponent: function(){
        this.title = '<i class="fa fa-tasks glyph"></i> Tambahkan Produk yang Dibeli Pelanggan';

        this.items = [{
            xtype: 'form',
            layout: 'vbox',
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
                layout: 'hbox',
                cls: 'panel',
                margin: '0 0 10 0',
                pediting: 30,
                width: 900,
                items: [{
                    xtype: 'combo-stock',
                    fieldLabel: 'Produk',
                    name: 'stock',
                    reference: 'stock',
                    afterLabelTextTpl: REQUIRED,
                    allowBlank: false,
                    width: 350,
                    listeners: {
                        'select': 'productSelect'
                    }
                },{
                    xtype: 'field-stock-amount',
                    fieldLabel: 'Jumlah',
                    name: 'amount',
                    step: 1,
                    tabOnEnter: true,
                    value: 1,
                    margin: '0 0 0 50',
                    width: 75
                },{
                    xtype: 'label',
                    bind: {
                        text: '{unit_name}'
                    },
                    text: 'Unit',
                    margin: '30 0 0 10'
                },{
                    xtype: 'combo-sell-type',
                    fieldLabel: 'Tipe',
                    name: 'type',
                    afterLabelTextTpl: REQUIRED,
                    allowBlank: false,
                    saveOnEnter: true,
                    value: 'Public',
                    margin: '0 0 0 50',
                    width: 150
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
                cls: 'panel',
                width: 900,
                items: [{
                    xtype: 'container',
                    html: 'Pengaturan Tambahan',
                    cls: 'panel-header'
                },{
                    xtype: 'container',
                    layout: 'hbox',
                    margin: '20 30',
                    anchor: '100%',
                    items:[{
                        xtype: 'field-price',
                        fieldLabel: 'Jual Biasa',
                        name: 'stock_sell_public',
                        bind: {
                            value: '{sell_public}'
                        },
                        saveOnEnter: true,
                        width: 150
                    },{
                        xtype: 'field-price',
                        fieldLabel: 'Jual Grosir',
                        name: 'stock_sell_distributor',
                        bind: {
                            value: '{sell_distributor}'
                        },
                        saveOnEnter: true,
                        margin: '0 0 0 50',
                        width: 150
                    },{
                        xtype: 'field-price',
                        fieldLabel: 'Jual Lain',
                        name: 'stock_sell_misc',
                        bind: {
                            value: '{sell_misc}'
                        },
                        saveOnEnter: true,
                        margin: '0 0 0 50',
                        width: 150
                    }]
                },{
                    xtype: 'container',
                    anchor: '100%',
                    margin: '20 30',
                    layout: 'hbox',
                    items:[{
                        xtype: 'field-price',
                        fieldLabel: 'Harga Beli',
                        name: 'stock_buy',
                        bind: {
                            value: '{buy}'
                        },
                        saveOnEnter: true,
                        width: 150
                    },{
                        xtype: 'field-discount',
                        fieldLabel: 'Diskon (%)',
                        name: 'stock_discount',
                        bind: {
                            value: '{discount}'
                        },
                        saveOnEnter: true,
                        margin: '0 0 0 50',
                        width:150
                    }]
                }]
            }]
        }];

        this.callParent(arguments);
    }
});