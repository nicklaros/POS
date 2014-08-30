Ext.define('POS.view.form.Login' ,{
    extend: 'Ext.form.Panel',
    alias : 'widget.login',
    controller: 'login',

    requires: [
        'POS.view.form.LoginController'
    ],

    monitorValid:true,
    padding: '10 25',
    items: [{
        xtype: 'textfield',
        fieldLabel: 'User ID',
        labelAlign: 'top',
        name: 'user',
        allowBlank: false,
        msgTarget: 'side',
        anchor: '100%'
    },{
        xtype: 'textfield',
        fieldLabel: 'Password',
        labelAlign: 'top',
        reference: 'pass_unencrypted',
        inputType:'password',
        submitValue: false,
        allowBlank: false,
        msgTarget: 'side',
        anchor: '100%',
        listeners: {
            blur: 'blurPass'
        }
    },{
        xtype: 'hidden',
        name: 'pass',
        reference: 'pass'
    }],
    dockedItems: [{
        xtype: 'toolbar',
        dock: 'bottom',
        items: [
            '->',
            {
                text: '<i class="fa fa-sign-in glyph"></i> Ok',
                handler: 'login'
            }
        ]
    }]
});