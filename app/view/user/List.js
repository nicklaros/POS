Ext.define('POS.view.user.List' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.listuser',
    controller: 'listuser',

    requires: [
        'POS.store.User',
        'POS.view.user.Add',
        'POS.view.user.Edit',
        'POS.view.user.Search',
        'POS.view.user.ListController'
    ],

    autoScroll: true,
    columnLines: true,
    closable: true,
    selType: 'checkboxmodel',
    stripeRows: true,

    initComponent: function() {
        this.title = '<i class="fa fa-user glyph"></i> User';

        var store = 'POS.store.User';
        this.store = store;

        this.columns = [
            {header: 'id', dataIndex:'id', hidden:true},
            {header: 'Level', dataIndex: 'level', width:75},
            {header: 'User ID', dataIndex: 'user', width:100},
            {header: 'Nama', dataIndex: 'nama', width:150},
            {header: 'Alamat', dataIndex: 'alamat', width:175},
            {header: 'Telp', dataIndex: 'telp', width:150}
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
                text:'<i class="fa fa-key glyph"></i> Reset Password',
                reference: 'resetPassword',
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