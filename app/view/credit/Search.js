Ext.define('POS.view.credit.Search' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.search-credit',
    id: 'search-credit',
    controller: 'search-credit',

    requires: [
        'POS.custom.field.ComboPaymentStatus',
        'POS.view.credit.SearchController'
    ],

    autoShow: true,
    constrain: true,
    layout: 'anchor',
    resizable: false,
    width: 300,

    initComponent: function(){
        this.title = '<i class="fa fa-calculator glyph"></i> Pencarian Piutang Penjualan';

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
                name: 'id',
                reference: 'id',
                emptyText: EMPTY_TEXT_0,
                searchOnEnter: true,
                selectOnFocus: true,
                anchor: '100%'
            },{
                xtype: 'textfield',
                fieldLabel: 'Nomor Nota Penjualan',
                name: 'sales_id',
                reference: 'sales_id',
                emptyText: EMPTY_TEXT_0,
                searchOnEnter: true,
                selectOnFocus: true,
                anchor: '100%'
            },{
                xtype: 'combo-payment-status',
                fieldLabel: 'Status Piutang',
                name: 'credit_status',
                emptyText: EMPTY_TEXT_0,
                searchOnEnter: true,
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