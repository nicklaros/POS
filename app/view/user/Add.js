Ext.define('POS.view.user.Add' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.add-user',
    id: 'add-user',
    controller: 'add-user',

    requires: [
        'POS.custom.field.ComboRole',
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
                xtype: 'combo-role',
                fieldLabel: 'Jabatan',
                name: 'role_id',
                afterLabelTextTpl: REQUIRED,
                allowBlank: false,
                width: 150
            },{
                xtype: 'textfield',
                fieldLabel: 'User ID',
                name: 'user',
                reference: 'user',
                afterLabelTextTpl: REQUIRED,
                allowBlank: false,
                maskRe: MASK_RE_1,
                maxLength: 30,
                width: 250
            },{
                xtype: 'container',
                html: 'Password awal sama dengan User ID',
                cls: 'warning'
            },{
                xtype: 'textfield',
                fieldLabel: 'Nama',
                name: 'name',
                afterLabelTextTpl: REQUIRED,
                allowBlank: false,
                maskRe: MASK_RE_0,
                maxLength: 30,
                width: 250
            },{
                xtype: 'textfield',
                fieldLabel: 'Alamat',
                name: 'address',
                maskRe: MASK_RE_0,
                maxLength: 30,
                width: 350
            },{
                xtype: 'textfield',
                fieldLabel: 'Telp',
                name: 'phone',
                maskRe: MASK_RE_0,
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