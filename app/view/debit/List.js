Ext.define('POS.view.debit.List' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.list-debit',
    controller: 'list-debit',

    requires: [
        'POS.fn.Render',
        'Ext.ux.container.ButtonSegment',
        'POS.store.Debit',
        'POS.view.debit.ListController',
        'POS.view.debit.ListPayment',
        'POS.view.debit.Pay',
        'POS.view.debit.Search'
    ],

    autoScroll: true,
    columnLines: true,
    closable: true,
    selType: 'checkboxmodel',
    stripeRows: true,

    initComponent: function() {
        this.title = '<i class="fa fa-calculator glyph"></i> Hutang Pembelian';

        var store = POS.app.getStore('Debit');
        this.store = store;

        this.columns = [
            {header: 'Kode', dataIndex:'id', width: 75},
            {header: 'Nota Pembelian', dataIndex:'purchase_id', width: 125},
            {header: 'Tanggal', dataIndex: 'date', width: 150, renderer: POS.fn.Render.date},
            {header: 'Nama', dataIndex: 'second_party_name', width: 200},
            {header: 'Hutang', dataIndex: 'total', width: 125, renderer: POS.fn.Render.currency, align: 'right'},
            {header: 'Dibayar', dataIndex: 'paid', width: 125, renderer: POS.fn.Render.currency, align: 'right'},
            {header: 'Sisa Hutang', dataIndex: 'balance', width: 125, renderer: POS.fn.Render.creditBalance, align: 'right'},
            {header: 'Kembali', dataIndex: 'cash_back', width: 125, renderer: POS.fn.Render.currency, align: 'right'}
        ];

        this.dockedItems = [{
            xtype: 'toolbar',
            dock: 'top',
            ui: 'footer',
            items: [{
                text: '<i class="fa fa-calculator glyph"></i> Data Pembayaran',
                handler: 'listPayment'
            },'-',{
                text: '<i class="fa fa-money glyph"></i> Bayar',
                reference: 'pay',
                handler: 'pay',
                disabled: true
            },{
                text: '<i class="fa fa-credit-card glyph"></i> Detail Pembelian',
                reference: 'purchase_detail',
                handler: 'purchaseDetail',
                disabled: true
            },{
                xtype: 'buttonsegment',
                items: [{
                    text: '<i class="fa fa-search glyph"></i> Cari',
                    handler: 'search'
                },{
                    text: '<i class="fa fa-undo glyph"></i>',
                    handler: 'reset'
                }]
            }]
        },{
            xtype: 'pagingtoolbar',
            store: store,
            dock: 'bottom',
            displayInfo: true,
            displayMsg: 'Menampilkan {0} - {1} dari total {2} data'
        }];

        this.callParent(arguments);
    }
});