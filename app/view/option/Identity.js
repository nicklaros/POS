Ext.define('POS.view.option.Identity', {
    extend: 'Ext.container.Container',
    alias: 'widget.option-identity',
    controller: 'option-identity',

    requires: [
        'POS.view.option.IdentityController'
    ],
    
    layout: 'vbox',
    
    items: [{
        xtype: 'form',
        bodyPadding: 30,
        bodyStyle: {
            border: '0 !important'
        },
        cls: 'panel',
        monitorValid:true,
        width: '100%',
        items: [{
            xtype: 'textfield',
            fieldLabel: 'Nama',
            name: 'client_name',
            allowBlank: false,
            afterLabelTextTpl: REQUIRED,
            maskRe: MASK_RE_0,
            maxLength: 128,
            tabOnEnter: true,
            width: 350
        },{
            xtype: 'textfield',
            fieldLabel: 'Alamat',
            name: 'client_address',
            maskRe: MASK_RE_0,
            maxLength: 128,
            tabOnEnter: true,
            width: 350
        },{
            xtype: 'textfield',
            fieldLabel: 'Nomor Telepon',
            name: 'client_phone',
            maskRe: MASK_RE_2,
            maxLength: 20,
            tabOnEnter: true,
            width: 200
        },{
            xtype: 'textfield',
            fieldLabel: 'Email',
            name: 'client_email',
            maskRe: MASK_RE_4,
            maxLength: 128,
            tabOnEnter: true,
            width: 300
        },{
            xtype: 'textfield',
            fieldLabel: 'Website',
            name: 'client_website',
            maskRe: MASK_RE_3,
            maxLength: 128,
            saveOnEnter: true,
            width: 300
        }]
    },{
        xtype: 'container',
        layout: 'hbox',
        margin: '15 0 0 0',
        items: [{
            xtype: 'button',
            text: '<i class="fa fa-save glyph"></i> Simpan',
            handler: 'saveIdentity'
        },{
            xtype: 'container',
            reference: 'status',
            margin: '5 0 0 25'
        }]
    }]
});