Ext.define('POS.view.credit.List' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.list-credit',
    controller: 'list-credit',

    requires: [
        'Ext.fn.Render',
        'Ext.ux.container.ButtonSegment',
        'POS.view.credit.ListController',
        'POS.view.credit.ListPayment',
        'POS.view.credit.Pay'
    ],

    autoScroll: true,
    columnLines: true,
    closable: true,
    selType: 'checkboxmodel',
    stripeRows: true,

    initComponent: function() {
        this.title = '<i class="fa fa-calculator glyph"></i> Piutang';

        var store = POS.app.getStore('Credit');
        this.store = store;

        this.columns = [
            {header: 'Kode', dataIndex:'id', width: 75},
            {header: 'Nota Penjualan', dataIndex:'sales_id', width: 125},
            {header: 'Tanggal', dataIndex: 'date', width: 150, renderer: Ext.fn.Render.date},
            {header: 'Pelanggan', dataIndex: 'customer_name', width: 200},
            {header: 'Piutang', dataIndex: 'total', width: 125, renderer: Ext.fn.Render.currency, align: 'right'},
            {header: 'Dibayar', dataIndex: 'paid', width: 125, renderer: Ext.fn.Render.currency, align: 'right'},
            {header: 'Sisa Piutang', dataIndex: 'balance', width: 125, renderer: Ext.fn.Render.creditBalance, align: 'right'},
            {header: 'Kembali', dataIndex: 'cash_back', width: 125, renderer: Ext.fn.Render.currency, align: 'right'}
        ];

        this.dockedItems = [{
            xtype: 'toolbar',
            dock: 'top',
            ui: 'footer',
            items: [{
                text: '<i class="fa fa-credit-card glyph"></i> Detail Penjualan',
                reference: 'sales_detail',
                handler: 'salesDetail',
                disabled: true
            },{
                text: '<i class="fa fa-credit-card glyph"></i> Bayar',
                reference: 'pay',
                handler: 'pay',
                disabled: true
            },{
                text: '<i class="fa fa-credit-card glyph"></i> Data Pembayaran',
                handler: 'listPayment'
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