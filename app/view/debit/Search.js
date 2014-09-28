Ext.define('POS.view.debit.Search' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.search-debit',
    id: 'search-debit',
    controller: 'search-debit',

    requires: [
        'POS.custom.field.ComboPaymentStatus',
        'POS.view.debit.SearchController'
    ],

    autoShow: true,
    constrain: true,
    layout: 'anchor',
    resizable: false,
    width: 300,

    initComponent: function(){
        this.title = '<i class="fa fa-calculator glyph"></i> Pencarian Hutang Pembelian';

        this.items = [{
            xtype: 'form',
            bodyPadding: 10,
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Nama',
                name: 'second_party_name',
                reference: 'second_party_name',
                emptyText: EMPTY_TEXT_0,
                searchOnEnter: true,
                selectOnFocus: true,
                anchor: '100%'
            },{
                xtype: 'textfield',
                fieldLabel: 'Kode Hutang',
                name: 'id',
                reference: 'id',
                emptyText: EMPTY_TEXT_0,
                searchOnEnter: true,
                selectOnFocus: true,
                anchor: '100%'
            },{
                xtype: 'textfield',
                fieldLabel: 'Nomor Nota Pembelian',
                name: 'purchase_id',
                reference: 'purchase_id',
                emptyText: EMPTY_TEXT_0,
                searchOnEnter: true,
                selectOnFocus: true,
                anchor: '100%'
            },{
                xtype: 'combo-payment-status',
                fieldLabel: 'Status Hutang',
                name: 'debit_status',
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