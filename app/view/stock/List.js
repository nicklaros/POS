Ext.define('POS.view.stock.List' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.list-stock',
    controller: 'list-stock',

    requires: [
        'Ext.fn.Render',
        'POS.store.Stock',
        'POS.view.stock.Add',
        'POS.view.stock.Edit',
        'POS.view.stock.ListController',
        'POS.view.stock.Search'
    ],

    autoScroll: true,
    columnLines: true,
    closable: true,
    selType: 'checkboxmodel',
    stripeRows: true,

    initComponent: function() {
        this.title = '<i class="fa fa-tasks glyph"></i> Stock';

        var store = POS.app.getStore('POS.store.Stock');
        this.store = store;

        this.columns = [
            {header: 'id', dataIndex:'id', hidden:true},
            {header: 'Kode', dataIndex: 'code', width: 120},
            {header: 'Produk', dataIndex: 'product', width: 275},
            {header: 'Satuan', dataIndex: 'unit', width: 100},
            {header: 'Stock', dataIndex: 'amount', width: 70, align: 'right'},
            {header: 'Harga<br />Beli', dataIndex: 'buy', width: 100, renderer: Ext.fn.Render.currency, align: 'right'},
            {
                text: 'Harga Jual',
                columns:[
                    {header: 'Biasa', dataIndex: 'sell_public', width: 100, renderer: Ext.fn.Render.currency, align: 'right'},
                    {header: 'Grosir', dataIndex: 'sell_distributor', width: 100, renderer: Ext.fn.Render.currency, align: 'right'},
                    {header: 'Lain', dataIndex: 'sell_misc', width: 100, renderer: Ext.fn.Render.currency, align: 'right'}
                ]
            },
            {header: 'Diskon', dataIndex: 'discount', width: 90, renderer: Ext.fn.Render.diskon, align: 'right'}
        ];

        this.dockedItems = [{
            xtype: 'toolbar',
            dock: 'top',
            ui: 'footer',
            items: [{
                text: '<i class="fa fa-plus-square glyph"></i> Tambah',
                reference: 'add'
            },{
                text: '<i class="fa fa-edit glyph"></i> Ubah',
                reference: 'edit',
                disabled: true
            },{
                text: '<i class="fa fa-trash-o glyph"></i> Hapus',
                reference: 'delete',
                disabled: true
            },{
                text: '<i class="fa fa-search glyph"></i> Cari',
                reference: 'search'
            },{
                text: '<i class="fa fa-undo glyph"></i> Reset Pencarian',
                reference: 'reset'
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