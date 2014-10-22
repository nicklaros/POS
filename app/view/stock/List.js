Ext.define('POS.view.stock.List' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.list-stock',
    controller: 'list-stock',

    requires: [
        'POS.fn.Render',
        'Ext.ux.container.ButtonSegment',
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

        var store = POS.app.getStore('Stock');
        this.store = store;

        this.columns = [
            {header: 'id', dataIndex:'id', hidden:true},
            {header: 'Kode', dataIndex: 'code', width: 120},
            {header: 'Produk', dataIndex: 'product', width: 275},
            {header: 'Satuan', dataIndex: 'unit', width: 100},
            {
                text: 'Harga Jual',
                columns:[
                    {header: 'Biasa', dataIndex: 'sell_public', width: 100, renderer: function(value){
                        return POS.fn.Render.currency(value, 'green bold');
                    }, align: 'right'},
                    {header: 'Grosir', dataIndex: 'sell_distributor', width: 100, renderer: POS.fn.Render.currency, align: 'right'},
                    {header: 'Lain', dataIndex: 'sell_misc', width: 100, renderer: POS.fn.Render.currency, align: 'right'}
                ]
            },
            {header: 'Stock', dataIndex: 'amount', width: 70, renderer: POS.fn.Render.amountOnGrid, align: 'right'},
            {header: 'Harga<br />Beli', dataIndex: 'buy', width: 100, renderer: POS.fn.Render.currency, align: 'right'},
            {header: 'Diskon', dataIndex: 'discount', width: 90, renderer: POS.fn.Render.discount, align: 'right'}
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
                handler: 'remove',
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