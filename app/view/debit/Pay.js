Ext.define('POS.view.debit.Pay' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.pay-debit',
    controller: 'pay-debit',
    
    requires: [
        'POS.custom.field.ComboCashier',
        'POS.custom.field.Date',
        'POS.custom.field.Price',
        'POS.view.debit.PayController'
    ],

    layout: 'anchor',
    
	autoScroll: true,
    autoShow: false,
    constrain: true,
    modal: false,
    resizable: false,
    
    width: 300,

    initComponent: function(){
        this.title = '<i class="fa fa-file-archive-o glyph"></i> Bayar Hutang';

        this.items = [{
            xtype: 'form',
            monitorValid:true,
            bodyPadding: 5,
            items: [{
                xtype: 'field-date',
                fieldLabel: 'Tanggal',
                name: 'date',
                afterLabelTextTpl: REQUIRED,
                allowBlank: false,
                value: new Date(),
                width: 200
            },{
                xtype: 'textfield',
                fieldLabel: 'Kode Hutang',
                name: 'debit_id',
                readOnly: true,
                width:250
            },{
                xtype: 'textfield',
                fieldLabel: 'Nama',
                name: 'second_party_name',
                readOnly: true,
                width:250
            },{
                xtype: 'combo-cashier',
                fieldLabel: 'Kasir',
                name: 'cashier',
                reference: 'cashier',
                afterLabelTextTpl: REQUIRED,
                allowBlank: false,
                readOnly: true,
                width: 200
            },{
                xtype: 'field-price',
                fieldLabel: 'Besar Hutang',
                name: 'debit',
                reference: 'debit',
                readOnly: true,
                width: 150
            },{
                xtype: 'field-price',
                fieldLabel: 'Dibayar',
                name: 'paid',
                reference: 'paid',
                afterLabelTextTpl: REQUIRED,
                allowBlank: false,
                saveOnEnter: true,
                selectOnFocus: true,
                value: 0,
                width: 150,
                listeners: {
                    change: 'setBalance'
                }
            },{
                xtype: 'field-price',
                fieldLabel: 'Kembali',
                name: 'balance',
                reference: 'balance',
                readOnly: true,
                width: 150
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

        this.maxHeight = Ext.getBody().getViewSize().height;

        this.callParent(arguments);
    }
});