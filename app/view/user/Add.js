Ext.define('POS.view.user.Add' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.adduser',
    id: 'adduser',
    controller: 'adduser',

    requires: [
        'POS.store.combo.LevelUser',
        'POS.view.user.AddController'
    ],

    autoShow: true,
    constrain: true,
    layout: 'anchor',
    resizable: false,
    width: 450,

    initComponent: function(){
        this.title = '<i class="fa fa-user glyph"></i> Tambah User';

        this.items = [{
            xtype: 'form',
            monitorValid: true,
            bodyPadding: 10,
            items: [{
                xtype: 'combo',
                fieldLabel: 'Level',
                name: 'level',
                triggerAction: 'all',
                editable: false,
                queryMode: 'local',
                store: 'POS.store.combo.LevelUser',
                displayField: 'val',
                valueField: 'val',
                value: 'Pegawai',
                forceSelection: true,
                width: 150
            },{
                xtype: 'textfield',
                fieldLabel: 'User ID',
                name: 'user',
                reference: 'user',
                afterLabelTextTpl: REQ,
                allowBlank: false,
                maskRe: MR1,
                maxLength: 30,
                width: 250
            },{
                xtype: 'container',
                html: 'Password awal sama dengan User ID',
                cls: 'warning'
            },{
                xtype: 'textfield',
                fieldLabel: 'Nama',
                name: 'nama',
                afterLabelTextTpl: REQ,
                allowBlank: false,
                maskRe: MR0,
                maxLength: 30,
                width: 250
            },{
                xtype: 'textfield',
                fieldLabel: 'Alamat',
                name: 'alamat',
                maskRe: MR0,
                maxLength: 30,
                width: 350
            },{
                xtype: 'textfield',
                fieldLabel: 'Telp',
                name: 'telp',
                maskRe: MR0,
                maxLength: 15,
                width: 350
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