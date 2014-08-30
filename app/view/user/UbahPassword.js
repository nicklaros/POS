Ext.define('klikec.view.user.UbahPassword' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.ubahPassword',

    layout: 'anchor',
    autoShow: true,
    constrainHeader: true,
    resizable: false,
    plain: true,
    border: false,
    modal:true,
    width: 450,
    autoScroll: true,
	
    initComponent: function(){
        this.title = '<div class="fontawesome-key glyph" style="position:relative;top:-1px;"></div><div class="glyphCaption">Ubah Password</div>';

        this.items = [{
            xtype: 'form',
            monitorValid:true,
            bodyPadding: 5,
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Password Lama',
                afterLabelTextTpl: required,
                name: 'oldPassword',
                allowBlank: false,
                inputType: 'password',
                minLength: 4,
                submitValue: false,
                width: 275
            },{
                xtype: 'hidden',
                name: 'oldPasswordEncrypt'
            },{
                xtype: 'textfield',
                fieldLabel: 'Password Baru',
                afterLabelTextTpl: required,
                name: 'newPassword',
                allowBlank: false,
                inputType: 'password',
                minLength: 4,
                submitValue: false,
                width: 275
            },{
                xtype: 'textfield',
                fieldLabel: 'Verify Password',
                afterLabelTextTpl: required,
                name: 'verifyPassword',
                allowBlank: false,
                inputType: 'password',
                minLength: 4,
                submitValue: false,
                width: 275,
                validator: function(value) {
                    var pass = this.previousSibling('[name=newPassword]');
                    return (value === pass.getValue()) ? true : 'Password tidak sama.'
                }
            },{
                xtype: 'hidden',
                name: 'newPasswordEncrypt'
            }],
            dockedItems: [{
                xtype: 'toolbar',
                dock: 'top',
                ui: 'footer',
                items: [
                    {action:'save', text:'<div class="fontawesome-save glyph"></div><div class="glyphCaption">Simpan</div>', formBind: true},
                    {action:'cancel', text:'<div class="fontawesome-undo glyph" style="position:relative;top:-1px;"></div><div class="glyphCaption">Batal</div>'}
                ]
            }],
            api: {
                submit: CurrentUsers.ubahPassword
            }
        }];

        this.callParent(arguments);
    }
});