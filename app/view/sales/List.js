Ext.define('POS.view.sales.List' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.list-sales',
    controller: 'list-sales',

    requires: [
        'Ext.fn.Render',
        'Ext.ux.container.ButtonSegment',
        'POS.store.Sales',
        'POS.view.sales.Add',
        'POS.view.sales.ListController'
    ],

    autoScroll: true,
    columnLines: true,
    closable: true,
    selType: 'checkboxmodel',
    stripeRows: true,

    initComponent: function() {
        this.title = '<i class="fa fa-tasks glyph"></i> Penjualan';

        var store = POS.app.getStore('POS.store.Sales');
        this.store = store;

        this.columns = [
            {header: 'Nomor', dataIndex:'id', width: 75},
            {header: 'Tanggal', dataIndex: 'date', width: 120, renderer: Ext.fn.Render.date},
            {header: 'Pelanggan', dataIndex: 'customer', width: 150},
            {header: 'Total', dataIndex: 'total_price', width: 100, renderer: Ext.fn.Render.currency, align: 'right'},
            {header: 'Dibayar', dataIndex: 'paid', width: 100, renderer: Ext.fn.Render.currency, align: 'right'},
            {header: 'Kembali', dataIndex: 'balance', width: 100, renderer: Ext.fn.Render.currency, align: 'right'},
            {header: 'Kasir', dataIndex: 'cashier', width: 120},
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
            },{
                text: '<i class="fa fa-edit glyph"></i> Ubah',
                reference: 'edit',
                handler: 'edit',
                disabled: true
            },{
                text: '<i class="fa fa-trash-o glyph"></i> Hapus',
                reference: 'delete',
                handler: 'delete',
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