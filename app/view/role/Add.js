Ext.define('POS.view.role.Add' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.add-role',
    id: 'add-role',
    controller: 'add-role',

    requires: [
        'POS.custom.field.RoleName',
        'POS.view.role.AddController'
    ],

    layout: 'anchor',
    
    autoShow: true,
    constrain: true,
    resizable: false,
    width: 350,
    
    bindCombo: null,

    initComponent: function(){
        this.title = '<i class="fa fa-briefcase glyph"></i> Tambah Jabatan';

        this.items = [{
            xtype: 'form',
            monitorValid: true,
            bodyPadding: 10,
            items: [{
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