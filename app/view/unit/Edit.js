Ext.define('POS.view.unit.Edit' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.edit-unit',
    id: 'edit-unit',
    controller: 'edit-unit',

    requires: [
        'POS.custom.field.UnitName',
        'POS.view.unit.EditController'
    ],

    layout: 'anchor',
    
    autoShow: true,
    constrain: true,
    resizable: false,
    width: 350,

    initComponent: function(){
        this.title = '<i class="fa fa-cubes glyph"></i> Ubah Satuan';

        this.items = [{
            xtype: 'form',
            monitorValid: true,
            bodyPadding: 10,
            items: [{
                xtype: 'hidden',
                name: 'id'
            },{
                xtype: 'field-unit-name',
                fieldLabel: 'Nama Satuan',
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