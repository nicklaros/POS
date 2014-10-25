Ext.define('POS.view.customer.List', {
    extend: 'Ext.grid.Panel',
    alias : 'widget.list-customer',
    controller: 'list-customer',

    requires: [
        'Ext.ux.container.ButtonSegment',
        'POS.store.Customer',
        'POS.view.customer.Add',
        'POS.view.customer.Detail',
        'POS.view.customer.Edit',
        'POS.view.customer.ListController',
        'POS.view.customer.Search'
    ],

    autoScroll: true,
    columnLines: true,
    closable: true,
    selType: 'checkboxmodel',
    stripeRows: true,

    initComponent: function() {
        this.title = '<i class="fa fa-group glyph"></i> Pelanggan';

        var store = POS.app.getStore('Customer');
        this.store = store;

        this.columns = [
            {header: 'Terdaftar Pada', dataIndex: 'registered_date', width: 150, renderer: POS.fn.Render.date},
            {header: 'Nama', dataIndex: 'name', width: 200},
            {header: 'Alamat', dataIndex: 'address', width: 200},
            {header: 'Tanggal lahir', dataIndex: 'birthday', width: 150, renderer: POS.fn.Render.date},
            {header: 'Jenis Kelamin', dataIndex: 'gender', width: 125, renderer: POS.fn.Render.gender},
            {header: 'Telp', dataIndex: 'phone', width: 125}
        ];

        this.dockedItems = [{
            xtype: 'toolbar',
            dock: 'top',
            ui: 'footer',
            items: [{
                text: '<i class="fa fa-credit-card glyph"></i> Detail',
                reference: 'detail',
                handler: 'detail',
                disabled: true
            },{
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