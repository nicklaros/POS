Ext.define('POS.view.supplier.List', {
    extend: 'Ext.grid.Panel',
    alias : 'widget.list-supplier',
    controller: 'list-supplier',

    requires: [
        'Ext.ux.container.ButtonSegment',
        'POS.store.Supplier',
        'POS.view.supplier.Add',
        'POS.view.supplier.Edit',
        'POS.view.supplier.ListController',
        'POS.view.supplier.Search'
    ],

    autoScroll: true,
    columnLines: true,
    closable: true,
    selType: 'checkboxmodel',
    stripeRows: true,

    initComponent: function() {
        this.title = '<i class="fa fa-building-o glyph"></i> Supplier';

        var store = POS.app.getStore('Supplier');
        this.store = store;

        this.columns = [
            {header: 'Nama', dataIndex: 'name', width: 200},
            {header: 'Alamat', dataIndex: 'address', width: 200},
            {header: 'Telp', dataIndex: 'phone', width: 125}
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