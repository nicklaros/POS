Ext.define('POS.view.supplier.Add', {
    extend: 'Ext.window.Window',
    alias : 'widget.add-supplier',
    id: 'add-supplier',
    controller: 'add-supplier',

    requires: [
        'POS.custom.field.Address',
        'POS.custom.field.ComboGender',
        'POS.custom.field.Name',
        'POS.custom.field.Phone',
        'POS.view.supplier.AddController'
    ],

    layout: 'vbox',
    
    autoShow: true,
    constrain: true,
    resizable: false,
    width: 350,
    
    bindCombo: null,

    initComponent: function(){
        this.title = '<i class="fa fa-building-o glyph"></i> Tambah Supplier';

        this.items = [{
            xtype: 'form',
            monitorValid: true,
            bodyPadding: 10,
            width: '100%',
            items: [{
                xtype: 'field-name',
                fieldLabel: 'Nama Supplier',
                name: 'name',
                reference: 'name',
                tabOnEnter: true,
                width: '100%'
            },{
                xtype: 'field-address',
                fieldLabel: 'Alamat',
                name: 'address',
                tabOnEnter: true,
                width: '100%'
            },{
                xtype: 'field-phone',
                fieldLabel: 'Telp',
                name: 'phone',
                saveOnEnter: true,
                width: '100%'
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