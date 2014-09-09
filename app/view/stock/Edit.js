Ext.define('POS.view.stock.Edit' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.edit-stock',
    id: 'edit-stock',
    controller: 'edit-stock',

    requires: [
        'POS.custom.field.ComboProduct',
        'POS.custom.field.ComboUnit',
        'POS.custom.field.Discount',
        'POS.custom.field.Price',
        'POS.custom.field.StockAmount',
        'POS.view.stock.EditController'
    ],

    autoShow: true,
    constrain: true,
    layout: 'anchor',
    resizable: false,
    width: 600,

    initComponent: function(){
        this.title = '<i class="fa fa-tasks glyph"></i> Ubah Stock';

        this.items = [{
            xtype: 'form',
            reference: 'form',
            monitorValid: true,
            bodyPadding: 10,
            items: [{
                xtype: 'hidden',
                name: 'id'
            },{
                xtype: 'combo-product',
                fieldLabel: 'Ketik nama / kode barang',
                name: 'product_id',
                reference: 'product',
                afterLabelTextTpl: REQUIRED,
                allowBlank: false,
                width: 350
            },{
                xtype: 'container',
                anchor: '100%',
                layout: 'hbox',
                margin: '0 0 10 0',
                items:[{
                    xtype: 'field-stock-amount',
                    fieldLabel: 'Jumlah Stock',
                    name: 'amount',
                    saveOnEnter: true,
                    width: 100
                },{
                    xtype: 'combo-unit',
                    fieldLabel: 'Satuan',
                    name: 'unit_id',
                    reference: 'unit',
                    afterLabelTextTpl: REQUIRED,
                    allowBlank: false,
                    margin: '0 0 0 20',
                    width: 150
                }]
            },{
                xtype: 'field-price',
                fieldLabel: 'Harga Beli',
                name: 'buy',
                saveOnEnter: true,
                width: 150
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
                    saveOnEnter: true,
                    width: 150
                },{
                    xtype: 'field-price',
                    fieldLabel: 'Grosir',
                    name: 'sell_distributor',
                    saveOnEnter: true,
                    margin: '0 0 0 20',
                    width: 150
                },{
                    xtype: 'field-price',
                    fieldLabel: 'Lain',
                    name: 'sell_misc',
                    saveOnEnter: true,
                    margin: '0 0 0 20',
                    width: 150
                }]
            },{
                xtype: 'field-discount',
                fieldLabel: 'Diskon (%)',
                name: 'discount',
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