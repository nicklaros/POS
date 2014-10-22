Ext.define('POS.view.sales.List' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.list-sales',
    controller: 'list-sales',

    requires: [
        'POS.fn.Render',
        'Ext.ux.container.ButtonSegment',
        'POS.store.Sales',
        'POS.view.sales.Add',
        'POS.view.sales.Detail',
        'POS.view.sales.Edit',
        'POS.view.sales.ListController',
        'POS.view.sales.Search'
    ],

    autoScroll: true,
    columnLines: true,
    closable: true,
    selType: 'checkboxmodel',
    stripeRows: true,

    initComponent: function() {
        this.title = '<i class="fa fa-shopping-cart glyph"></i> Penjualan';

        var store = POS.app.getStore('Sales');
        this.store = store;

        this.columns = [
            {header: 'Nota', dataIndex:'id', width: 75},
            {header: 'Tanggal', dataIndex: 'date', width: 150, renderer: POS.fn.Render.date},
            {header: 'Dijual Ke', dataIndex: 'second_party_name', width: 200},
            {header: 'Total', dataIndex: 'total_price', width: 125, renderer: POS.fn.Render.currency, align: 'right'},
            {header: 'Dibayar', dataIndex: 'paid', width: 125, renderer: POS.fn.Render.currency, align: 'right'},
            {header: 'Kembali', dataIndex: 'balance', width: 125, renderer: POS.fn.Render.paymentBalance, align: 'right'},
            {header: 'Kasir', dataIndex: 'cashier_name', width: 120},
            {header: 'Catatan', dataIndex: 'note', width: 150}
        ];

        this.dockedItems = [{
            xtype: 'toolbar',
            dock: 'top',
            ui: 'footer',
            items: [{
                text: '<i class="fa fa-plus-square glyph"></i> Tambah',
                reference: 'add',
                handler: 'add'
            }, '-', {
                text: '<i class="fa fa-credit-card glyph"></i> Detail',
                reference: 'detail',
                handler: 'detail',
                disabled: true
            },{
                text: '<i class="fa fa-edit glyph"></i> Ubah',
                reference: 'edit',
                handler: 'edit',
                disabled: true
            },{
                text: '<i class="fa fa-undo glyph"></i> Batalkan Penjualan',
                reference: 'cancel',
                handler: 'cancel',
                disabled: true
            },{
                text: '<i class="fa fa-print glyph"></i> Print',
                reference: 'print',
                handler: 'print',
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