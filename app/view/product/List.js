Ext.define('POS.view.product.List' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.list-product',
    controller: 'list-product',

    requires: [
        'POS.fn.Render',
        'Ext.ux.container.ButtonSegment',
        'POS.store.Product',
        'POS.view.product.Add',
        'POS.view.product.Edit',
        'POS.view.product.ListController',
        'POS.view.product.Search'
    ],

    autoScroll: true,
    columnLines: true,
    closable: true,
    selType: 'checkboxmodel',
    stripeRows: true,

    initComponent: function() {
        this.title = '<i class="fa fa-file-archive-o glyph"></i> Produk';

        var store = POS.app.getStore('Product');
        this.store = store;

        this.columns = [
            {header: 'id', dataIndex:'id', hidden:true},
            {header: 'Kode', dataIndex: 'code', width: 120},
            {header: 'Produk', dataIndex: 'name', width: 350}
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