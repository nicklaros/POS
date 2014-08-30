Ext.define('klikec.view.user.UbahBiodata' ,{
    extend: 'Ext.window.Window',
    alias :'widget.ubahBiodata',

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
        this.title = '<div class="fontawesome-edit glyph"></div><div class="glyphCaption">Ubah Data Diri</div>';

        this.items = [{
            xtype: 'form',
            monitorValid:true,
            bodyPadding: 5,
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Nama',
                allowBlank: false,
                name: 'nama',
                afterLabelTextTpl: required,
                maskRe: maskReChar,
                maxLength: '30',
                width:350
            },{
                xtype: 'textfield',
                fieldLabel: 'Alamat',
                name: 'alamat',
                maskRe: maskReChar,
                maxLength: '30',
                width:350
            }],
            dockedItems: [{
                xtype: 'toolbar',
                dock: 'top',
                ui: 'footer',
                items: [
                    {action:'save', text:'<div class="fontawesome-save glyph"></div><div class="glyphCaption">Simpan</div>', formBind: true},
                    {action:'cancel', text:'<div class="fontawesome-undo glyph"></div><div class="glyphCaption">Batal</div>'}
                ]
            }],
            api: {
                load: CurrentUsers.loadFormUbahBiodata,
                submit: CurrentUsers.ubahBiodata
            }
        }];

		this.callParent(arguments);
	}
});