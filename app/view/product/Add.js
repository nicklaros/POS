Ext.define('POS.view.product.Add' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.add-product',
    id: 'add-product',
    controller: 'add-product',

    requires: [
        'POS.custom.field.ProductCode',
        'POS.custom.field.ProductName',
        'POS.view.product.AddController'
    ],

    autoShow: true,
    constrain: true,
    layout: 'anchor',
    resizable: false,
    width: 350,
    
    bindCombo: null,

    initComponent: function(){
        this.title = '<i class="fa fa-file-archive-o glyph"></i> Tambah Data Produk';

        this.items = [{
            xtype: 'form',
            monitorValid: true,
            bodyPadding: 10,
            items: [{
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