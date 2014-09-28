Ext.define('POS.view.supplier.Edit', {
    extend: 'Ext.window.Window',
    alias : 'widget.edit-supplier',
    id: 'edit-supplier',
    controller: 'edit-supplier',

    requires: [
        'POS.custom.field.Address',
        'POS.custom.field.ComboGender',
        'POS.custom.field.Name',
        'POS.custom.field.Phone',
        'POS.view.supplier.EditController'
    ],

    layout: 'vbox',
    
    autoShow: false,
    constrain: true,
    resizable: false,
    width: 350,

    initComponent: function(){
        this.title = '<i class="fa fa-building-o glyph"></i> Ubah Supplier';

        this.items = [{
            xtype: 'form',
            monitorValid: true,
            bodyPadding: 10,
            width: '100%',
            items: [{
                xtype: 'hidden',
                name: 'id'
            },{
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