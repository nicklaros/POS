Ext.define('POS.view.credit.SearchPayment' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.search-credit-payment',
    id: 'search-credit-payment',
    controller: 'search-credit-payment',

    requires: [
        'POS.custom.field.Date',
        'POS.view.credit.SearchPaymentController'
    ],

    autoShow: true,
    constrain: true,
    layout: 'anchor',
    resizable: false,
    width: 300,

    initComponent: function(){
        this.title = '<i class="fa fa-calculator glyph"></i> Pencarian Data Pembayaran Piutang';

        this.items = [{
            xtype: 'form',
            bodyPadding: 10,
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Nama',
                name: 'second_party',
                reference: 'second_party',
                emptyText: EMPTY_TEXT_0,
                searchOnEnter: true,
                selectOnFocus: true,
                anchor: '100%'
            },{
                xtype: 'textfield',
                fieldLabel: 'Kode Piutang',
                name: 'credit_id',
                reference: 'credit_id',
                emptyText: EMPTY_TEXT_0,
                searchOnEnter: true,
                selectOnFocus: true,
                anchor: '100%'
            },{
                xtype: 'field-date',
                fieldLabel: 'Mulai Tanggal',
                name: 'start_date',
                emptyText: EMPTY_TEXT_0,
                searchOnEnter: true,
                selectOnFocus: true,
                anchor: '100%'
            },{
                xtype: 'field-date',
                fieldLabel: 'Hingga Tanggal',
                name: 'until_date',
                emptyText: EMPTY_TEXT_0,
                searchOnEnter: true,
                selectOnFocus: true,
                anchor: '100%'
            }]
        }];

        this.dockedItems = [{
            xtype: 'toolbar',
            dock: 'top',
            ui: 'footer',
            items: [{
                text: '<i class="fa fa-search glyph"></i> Cari',
                handler: 'search'
            },{
                text: '<i class="fa fa-undo glyph"></i> Batal',
                handler: 'cancel'
            }]
        }];

        this.callParent(arguments);
    }
});