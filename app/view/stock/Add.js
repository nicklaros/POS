Ext.define('POS.view.stock.Add' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.add-stock',
    id: 'add-stock',
    controller: 'add-stock',

    requires: [
        'POS.custom.field.ComboProduct',
        'POS.custom.field.Discount',
        'POS.custom.field.Price',
        'POS.view.stock.AddController'
    ],

    autoShow: true,
    constrain: true,
    layout: 'anchor',
    resizable: false,
    width: 600,

    initComponent: function(){
        this.title = '<i class="fa fa-tasks glyph"></i> Tambah Data Stock';

        this.items = [{
            xtype: 'form',
            monitorValid: true,
            bodyPadding: 10,
            items: [{
                xtype: 'combo-product',
                fieldLabel: 'Ketik nama / kode barang',
                name: 'product_id',
                reference: 'product',
                afterLabelTextTpl: REQUIRED,
                allowBlank: false,
                width: 500
            },{
                xtype: 'container',
                anchor: '100%',
                layout: 'hbox',
                margin: '0 0 10 0',
                items:[{
                    xtype: 'field-price',
                    fieldLabel: 'Harga Beli',
                    name: 'buy',
                    width: 150
                },{
                    xtype: 'numberfield',
                    fieldLabel: 'Jumlah Stock',
                    name: 'amount',
                    minValue: 0,
                    value: 1,
                    step: 10,
                    margin: '0 0 0 20',
                    width: 100
                },{
                    xtype: 'field-discount',
                    fieldLabel: 'Diskon (%)',
                    name: 'discount',
                    margin: '0 0 0 20',
                    width:150
                }]
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
                    width: 150
                },{
                    xtype: 'field-price',
                    fieldLabel: 'Grosir',
                    name: 'sell_distributor',
                    margin: '0 0 0 20',
                    width: 150
                },{
                    xtype: 'field-price',
                    fieldLabel: 'Lain',
                    name: 'sell_misc',
                    margin: '0 0 0 20',
                    width: 150
                }]
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