Ext.define('POS.view.debit.ListPayment' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.list-debit-payment',
    controller: 'list-debit-payment',

    requires: [
        'POS.fn.Render',
        'Ext.ux.container.ButtonSegment',
        'POS.store.DebitPayment',
        'POS.view.debit.ListPaymentController',
        'POS.view.debit.SearchPayment'
    ],

    autoScroll: true,
    columnLines: true,
    closable: true,
    selType: 'checkboxmodel',
    stripeRows: true,

    initComponent: function() {
        this.title = '<i class="fa fa-calculator glyph"></i> Pembayaran Hutang';

        var store = POS.app.getStore('DebitPayment');
        this.store = store;

        this.columns = [
            {header: 'Tanggal', dataIndex: 'date', width: 150, renderer: POS.fn.Render.date},
            {header: 'Kode Hutang', dataIndex:'debit_id', width: 125},
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