Ext.define('POS.view.product.Edit' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.edit-product',
    id: 'edit-product',
    controller: 'edit-product',

    requires: [
        'POS.custom.field.ProductCode',
        'POS.custom.field.ProductName',
        'POS.view.product.EditController'
    ],

    autoShow: true,
    constrain: true,
    layout: 'anchor',
    resizable: false,
    width: 350,

    initComponent: function(){
        this.title = '<i class="fa fa-file-archive-o glyph"></i> Ubah Produk';

        this.items = [{
            xtype: 'form',
            reference: 'form',
            monitorValid: true,
            bodyPadding: 10,
            items: [{
                xtype: 'hidden',
                name: 'id'
            },{
                xtype: 'field-product-code',
                fieldLabel: 'Kode produk',
                name: 'code',
                reference: 'code',
                tabOnEnter: true,
                width: 150
            },{
                xtype: 'field-product-name',
                fieldLabel: 'Nama produk',
                name: 'name',
                reference: 'name',
                saveOnEnter: true,
                anchor: '100%'
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