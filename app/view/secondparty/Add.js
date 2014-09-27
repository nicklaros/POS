Ext.define('POS.view.secondparty.Add', {
    extend: 'Ext.window.Window',
    alias : 'widget.add-second-party',
    id: 'add-second-party',
    controller: 'add-second-party',

    requires: [
        'POS.custom.field.Address',
        'POS.custom.field.ComboGender',
        'POS.custom.field.ComboSecondPartyType',
        'POS.custom.field.Name',
        'POS.custom.field.Phone',
        'POS.view.secondparty.AddController'
    ],

    layout: 'vbox',
    
    autoShow: true,
    constrain: true,
    resizable: false,
    width: 350,
    
    bindCombo: null,

    initComponent: function(){
        this.title = '<i class="fa fa-group glyph"></i> Tambah Pihak Kedua';

        this.items = [{
            xtype: 'form',
            monitorValid: true,
            bodyPadding: 10,
            width: '100%',
            items: [{
                xtype: 'field-name',
                fieldLabel: 'Nama',
                name: 'name',
                reference: 'name',
                tabOnEnter: true,
                width: '100%'
            },{
                xtype: 'field-address',
                fieldLabel: 'Alamat',
                name: 'address',
                tabOnEnter: true,
                width: '100%'
            },{
                xtype: 'combo-gender',
                fieldLabel: 'Jenis Kelamin',
                name: 'gender',
                afterLabelTextTpl: REQUIRED,
                allowBlank: false,
                tabOnEnter: true,
                value: 'Male',
                width: '100%'
            },{
                xtype: 'field-phone',
                fieldLabel: 'Telp',
                name: 'phone',
                tabOnEnter: true,
                width: '100%'
            },{
                xtype: 'combo-second-party-type',
                fieldLabel: 'Tipe',
                name: 'type',
                afterLabelTextTpl: REQUIRED,
                allowBlank: false,
                saveOnEnter: true,
                value: 'Customer',
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