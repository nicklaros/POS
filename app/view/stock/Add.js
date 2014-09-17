Ext.define('POS.view.stock.Add' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.add-stock',
    id: 'add-stock',
    controller: 'add-stock',

    requires: [
        'POS.custom.field.ComboProduct',
        'POS.custom.field.ComboUnit',
        'POS.custom.field.Discount',
        'POS.custom.field.Price',
        'POS.custom.field.StockAmount',
        'POS.view.stock.AddController'
    ],

    layout: 'anchor',
    
    autoShow: true,
    constrain: true,
    resizable: false,
    width: 600,

    initComponent: function(){
        this.title = '<i class="fa fa-tasks glyph"></i> Tambah Data Stock';

        this.items = [{
            xtype: 'form',
            monitorValid: true,
            bodyPadding: 10,
            items: [{
                xtype: 'container',
                anchor: '100%',
                layout: 'hbox',
                margin: '0 0 10 0',
                items:[{
                    xtype: 'combo-product',
                    fieldLabel: 'Ketik nama / kode produk',
                    name: 'product_id',
                    reference: 'product',
                    afterLabelTextTpl: REQUIRED,
                    allowBlank: false,
                    width: 350,
                    listeners: {
                        'select': 'onSelectProduct'
                    }
                },{
                    xtype: 'combo-unit',
                    fieldLabel: 'Satuan',
                    name: 'unit_id',
                    reference: 'unit',
                    afterLabelTextTpl: REQUIRED,
                    allowBlank: false,
                    selectOnFocus: true,
                    margin: '0 0 0 20',
                    width: 150,
                    listeners: {
                        'select': 'onSelectUnit'
                    }
                }]
            },{
                xtype: 'container',
                anchor: '100%',
                layout: 'hbox',
                margin: '0 0 10 0',
                items:[{
                    xtype: 'field-stock-amount',
                    fieldLabel: 'Jumlah Stock',
                    name: 'amount',
                    reference: 'amount',
                    width: 100,
                    listeners: {
                        'specialkey': 'onKeyAmount'
                    }
                },{
                    xtype: 'container',
                    html: 'atau',
                    margin: '30 0 0 30'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Tak terhingga',
                    name: 'unlimited',
                    inputValue: true,
                    margin: '26 0 0 30',
                    listeners: {
                        'change': 'onChangeUnlimited'
                    }
                }]
            },{
                xtype: 'field-price',
                fieldLabel: 'Harga Beli',
                name: 'buy',
                reference: 'buy',
                width: 150,
                listeners: {
                    'specialkey': 'onKeyBuy'
                }
            },{
                xtype: 'fieldset',
                title: 'Harga Jual',
                anchor: '100%',
                layout: 'hbox',
                margin: '10 0 10 0',
                padding: 10,
                items:[{
                    xtype: 'field-price',
                    fieldLabel: 'Biasa',
                    name: 'sell_public',
                    reference: 'sell_public',
                    tabOnEnter: true,
                    width: 150
                },{
                    xtype: 'field-price',
                    fieldLabel: 'Grosir',
                    name: 'sell_distributor',
                    reference: 'sell_distributor',
                    tabOnEnter: true,
                    margin: '0 0 0 20',
                    width: 150
                },{
                    xtype: 'field-price',
                    fieldLabel: 'Lain',
                    name: 'sell_misc',
                    reference: 'sell_misc',
                    margin: '0 0 0 20',
                    width: 150,
                    listeners: {
                        'specialkey': 'onKeyMisc'
                    }
                }]
            },{
                xtype: 'field-discount',
                fieldLabel: 'Diskon (%)',
                name: 'discount',
                reference: 'discount',
                saveOnEnter: true,
                width:150
            }]
        }];

        this.dockedItems = [{
            xtype: 'toolbar',
            dock: 'top',
            ui: 'footer',
            items: [{
                text: '<i class="fa fa-save glyph"></i> Simpan',
                handler: 'save'
            },{
                text: '<i class="fa fa-undo glyph"></i> Batal',
                handler: 'close'
            }]
        }];

        this.callParent(arguments);
    }
});