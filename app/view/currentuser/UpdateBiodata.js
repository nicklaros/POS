Ext.define('POS.view.currentuser.UpdateBiodata' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.update-biodata',
    id: 'update-biodata',
    controller: 'update-biodata',

    requires: [
        'POS.view.currentuser.UpdateBiodataController'
    ],

    autoShow: true,
    constrain: true,
    layout: 'anchor',
    resizable: false,
    width: 450,
	
    initComponent: function(){
        this.title = '<i class="fa fa-edit glyph"></i> Ubah Data Diri';

        this.items = [{
            xtype: 'form',
            monitorValid:true,
            bodyPadding: 5,
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Nama',
                name: 'name',
                allowBlank: false,
                afterLabelTextTpl: REQUIRED,
                maskRe: MASK_RE_0,
                maxLength: 128,
                tabOnEnter: true,
                width: 350
            },{
                xtype: 'textfield',
                fieldLabel: 'Alamat',
                name: 'address',
                maskRe: MASK_RE_0,
                maxLength: 128,
                tabOnEnter: true,
                width: 350
            },{
                xtype: 'textfield',
                fieldLabel: 'Nomor Telepon',
                name: 'phone',
                maskRe: MASK_RE_2,
                maxLength: 20,
                saveOnEnter: true,
                width: 200
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