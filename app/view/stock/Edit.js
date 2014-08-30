Ext.define('POS.view.stock.Edit' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.editstock',
    id: 'editstock',
    controller: 'editstock',

    requires: [
        'Ext.tpl.combo.Produk',
        'POS.store.combo.Barang',
        'POS.view.stock.EditController'
    ],

    autoShow: true,
    constrain: true,
    layout: 'anchor',
    resizable: false,
    width: 600,

    initComponent: function(){
        this.title = '<i class="fa fa-stock glyph"></i> Ubah Stock';

        this.items = [{
            xtype: 'form',
            reference: 'form',
            monitorValid: true,
            bodyPadding: 10,
            items: [{
                xtype: 'hidden',
                name: 'id'
            },{
                xtype: 'combo',
                fieldLabel: 'Ketik nama / kode barang',
                name: 'barang',
                reference: 'barang',
                afterLabelTextTpl: REQ,
                allowBlank: false,
                anyMatch: true,
                displayField: 'nama',
                forceSelection: true,
                hideTrigger: true,
                listConfig: {
                    itemTpl: Ext.create('Ext.tpl.combo.Produk')
                },
                matchFieldWidth: true,
                minChars: 1,
                queryDelay: 10,
                queryMode: 'remote',
                store: 'POS.store.combo.Barang',
                typeAhead: true,
                typeAheadDelay: 100,
                valueField: 'id',
                width: 500
            },{
                xtype: 'container',
                anchor: '100%',
                layout: 'hbox',
                margin: '10 0 10 0',
                padding: 10,
                items:[{
                    xtype: 'numberfield',
                    fieldLabel: 'Harga Beli',
                    name: 'hrg_beli',
                    minValue: 0,
                    value: 0,
                    step: 1000,
                    width: 150
                },{
                    xtype: 'numberfield',
                    fieldLabel: 'Jumlah Stock',
                    name: 'jumlah_stock',
                    minValue: 0,
                    value: 1,
                    step: 10,
                    margin: '0 0 0 20',
                    width: 100
                },{
                    xtype: 'numberfield',
                    fieldLabel: 'Diskon (%)',
                    name: 'diskon',
                    minValue: 0,
                    maxValue: 100,
                    value: 0,
                    step: 5,
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
                    xtype: 'numberfield',
                    fieldLabel: 'Biasa',
                    name: 'hrg_jual_biasa',
                    minValue: 0,
                    value: 0,
                    step: 1000,
                    width: 150
                },{
                    xtype: 'numberfield',
                    fieldLabel: 'Grosir',
                    name: 'hrg_jual_grosir',
                    minValue: 0,
                    value: 0,
                    step: 1000,
                    margin: '0 0 0 20',
                    width: 150
                },{
                    xtype: 'numberfield',
                    fieldLabel: 'Lain',
                    name: 'hrg_jual_lain',
                    minValue: 0,
                    value: 0,
                    step: 1000,
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