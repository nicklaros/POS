Ext.define('POS.view.sales.AddDetail' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.add-sales-detail',
    id: 'add-sales-detail',
    controller: 'add-sales-detail',
    viewModel: {
        type: 'add-sales-detail'
    },

    requires: [
        'POS.custom.field.ComboStock',
        'POS.custom.field.StockAmount',
        'POS.custom.field.ComboSellType',
        'POS.custom.field.Price',
        'POS.view.sales.AddDetailController',
        'POS.view.sales.AddDetailModel'
    ],

	autoScroll: true,
    autoShow: true,
    bodyStyle: {
        'background-color': '#e9eaed',
        border: '0 !important',
        padding: '25px'
    },
    cls: 'window',
    closeAction: 'hide',
    constrain: true,
    layout: 'anchor',
    maximized: true,
    modal: true,
    resizable: false,
    
    record: null,

    initComponent: function(){
        this.title = '<i class="fa fa-shopping-cart glyph"></i> Ubah Produk yang Dijual';

        this.items = [{
            xtype: 'form',
            reference: 'form',
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
                padding: 30,
                width: 900,
                items: [{
                    xtype: 'combo-sell-type',
                    fieldLabel: 'Tipe',
                    name: 'type',
                    reference: 'type',
                    afterLabelTextTpl: REQUIRED,
                    allowBlank: false,
                    tabOnEnter: true,
                    value: 'Public',
                    width: 150,
                    listeners: {
                        select: 'onTypeSelect'
                    }
                },{
                    xtype: 'combo-stock',
                    fieldLabel: 'Produk',
                    name: 'stock',
                    reference: 'stock',
                    afterLabelTextTpl: REQUIRED,
                    allowBlank: false,
                    margin: '0 0 0 50',
                    width: 350,
                    listeners: {
                        select: 'onProductSelect',
                        blur: 'onProductBlur'
                    }
                },{
                    xtype: 'field-stock-amount',
                    fieldLabel: 'Jumlah',
                    name: 'amount',
                    reference: 'amount',
                    afterLabelTextTpl: REQUIRED,
                    allowBlank: false,
                    step: 1,
                    saveOnEnter: true,
                    minValue: 0,
                    value: 1,
                    margin: '0 0 0 50',
                    width: 75
                },{
                    xtype: 'label',
                    reference: 'unit',
                    html: 'unit',
                    margin: '30 0 0 10'
                }]
            },{
                xtype: 'toolbar',
                ui: 'footer',
                margin: '0 0 30 0',
                width: 900,
                items: [{
                    xtype: 'label',
                    reference: 'status',
                    html: '',
                    margin: '30 0 0 10',
                    width: 550
                },
                    '->',
                {
                    text: '<i class="fa fa-save glyph"></i> Ubah',
                    handler: 'save'
                },{
                    text: '<i class="fa fa-reorder glyph"></i> [Esc] Lihat Total',
                    handler: 'close'
                }]
            },{
                xtype: 'container',
                cls: 'panel',
                hidden: true,
                bind: {
                    hidden: '{!stock.selection}'
                },
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
                        name: 'sell_public',
                        amountOnEnter: true,
                        width: 150
                    },{
                        xtype: 'field-price',
                        fieldLabel: 'Jual Grosir',
                        name: 'sell_distributor',
                        amountOnEnter: true,
                        margin: '0 0 0 50',
                        width: 150
                    },{
                        xtype: 'field-price',
                        fieldLabel: 'Jual Lain',
                        name: 'sell_misc',
                        amountOnEnter: true,
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
                        name: 'buy',
                        amountOnEnter: true,
                        width: 150
                    },{
                        xtype: 'field-discount',
                        fieldLabel: 'Diskon (%)',
                        name: 'discount',
                        amountOnEnter: true,
                        margin: '0 0 0 50',
                        width:150
                    }]
                }]
            },{
                xtype: 'hidden',
                name: 'product_name'
            },{
                xtype: 'hidden',
                name: 'unit_id'
            }]
        }];

        this.callParent(arguments);
    }
});