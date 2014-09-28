Ext.define('POS.view.currentuser.ChangePassword' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.change-password',
    id: 'change-password',
    controller: 'change-password',

    requires: [
        'POS.view.currentuser.ChangePasswordController'
    ],

    autoShow: true,
    constrain: true,
    layout: 'anchor',
    resizable: false,
    width: 450,
	
    initComponent: function(){
        this.title = '<i class="fa fa-key glyph"></i> Ubah Password';

        this.items = [{
            xtype: 'form',
            monitorValid:true,
            bodyPadding: 5,
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Password Lama',
                name: 'old_password',
                afterLabelTextTpl: REQUIRED,
                allowBlank: false,
                inputType: 'password',
                minLength: 4,
                submitValue: false,
                tabOnEnter: true,
                width: 275
            },{
                xtype: 'textfield',
                fieldLabel: 'Password Baru',
                name: 'new_password',
                afterLabelTextTpl: REQUIRED,
                allowBlank: false,
                inputType: 'password',
                minLength: 4,
                submitValue: false,
                tabOnEnter: true,
                width: 275
            },{
                xtype: 'textfield',
                fieldLabel: 'Masukkan Password Baru sekali lagi',
                name: 'verify_password',
                afterLabelTextTpl: REQUIRED,
                allowBlank: false,
                inputType: 'password',
                minLength: 4,
                saveOnEnter: true,
                submitValue: false,
                width: 275,
                validator: function(value) {
                    var pass = this.previousSibling('[name = new_password]');
                    return (value === pass.getValue()) ? true : 'Password tidak sama.'
                }
            }],
            dockedItems: [{
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
            }]
        }];

        this.callParent(arguments);
    }
});