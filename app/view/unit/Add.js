Ext.define('POS.view.unit.Add' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.add-unit',
    id: 'add-unit',
    controller: 'add-unit',

    requires: [
        'POS.custom.field.UnitName',
        'POS.view.unit.AddController'
    ],

    layout: 'anchor',
    
    autoShow: true,
    constrain: true,
    resizable: false,
    width: 350,
    
    bindCombo: null,

    initComponent: function(){
        this.title = '<i class="fa fa-cubes glyph"></i> Tambah Satuan';

        this.items = [{
            xtype: 'form',
            monitorValid: true,
            bodyPadding: 10,
            items: [{
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