Ext.define('POS.view.role.Edit' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.edit-role',
    id: 'edit-role',
    controller: 'edit-role',

    requires: [
        'POS.custom.field.UnitName',
        'POS.view.role.EditController'
    ],

    layout: 'anchor',
    
    autoShow: true,
    constrain: true,
    resizable: false,
    width: 350,

    initComponent: function(){
        this.title = '<i class="fa fa-briefcase glyph"></i> Ubah Jabatan';

        this.items = [{
            xtype: 'form',
            monitorValid: true,
            bodyPadding: 10,
            items: [{
                xtype: 'hidden',
                name: 'id'
            },{
                xtype: 'field-role-name',
                fieldLabel: 'Nama Jabatan',
                name: 'name',
                reference: 'name',
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