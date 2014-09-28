Ext.define('POS.view.customer.Add', {
    extend: 'Ext.window.Window',
    alias : 'widget.add-customer',
    id: 'add-customer',
    controller: 'add-customer',

    requires: [
        'POS.custom.field.Address',
        'POS.custom.field.ComboGender',
        'POS.custom.field.Name',
        'POS.custom.field.Phone',
        'POS.view.customer.AddController'
    ],

    layout: 'vbox',
    
    autoShow: true,
    constrain: true,
    resizable: false,
    width: 350,
    
    bindCombo: null,

    initComponent: function(){
        this.title = '<i class="fa fa-group glyph"></i> Tambah Pelanggan';

        this.items = [{
            xtype: 'form',
            monitorValid: true,
            bodyPadding: 10,
            width: '100%',
            items: [{
                xtype: 'field-date',
                fieldLabel: 'Terdaftar Pada',
                name: 'registered_date',
                afterLabelTextTpl: REQUIRED,
                allowBlank: false,
                tabOnEnter: true,
                value: new Date(),
                width: '100%'
            },{
                xtype: 'field-name',
                fieldLabel: 'Nama Pelanggan',
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
                xtype: 'field-date',
                fieldLabel: 'Tanggal Lahir',
                name: 'birthday',
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