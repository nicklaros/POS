Ext.define('POS.view.credit.ListPayment' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.list-credit-payment',
    controller: 'list-credit-payment',

    requires: [
        'POS.fn.Render',
        'Ext.ux.container.ButtonSegment',
        'POS.store.CreditPayment',
        'POS.view.credit.ListPaymentController',
        'POS.view.credit.SearchPayment'
    ],

    autoScroll: true,
    columnLines: true,
    closable: true,
    selType: 'checkboxmodel',
    stripeRows: true,

    initComponent: function() {
        this.title = '<i class="fa fa-calculator glyph"></i> Pembayaran Piutang';

        var store = POS.app.getStore('CreditPayment');
        this.store = store;

        this.columns = [
            {header: 'Tanggal', dataIndex: 'date', width: 150, renderer: POS.fn.Render.date},
            {header: 'Kode Piutang', dataIndex:'credit_id', width: 125},
            {header: 'Nama', dataIndex: 'second_party_name', width: 200},
            {header: 'Bayar', dataIndex: 'paid', width: 125, renderer: POS.fn.Render.currency, align: 'right'},
            {header: 'Kasir', dataIndex: 'cashier_name', width: 120}
        ];

        this.dockedItems = [{
            xtype: 'toolbar',
            dock: 'top',
            ui: 'footer',
            items: [{
                text: '<i class="fa fa-undo glyph"></i> Batalkan Pembayaran',
                reference: 'cancel',
                handler: 'cancel',
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