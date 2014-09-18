Ext.define('POS.view.user.List' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.list-user',
    controller: 'list-user',

    requires: [
        'Ext.ux.container.ButtonSegment',
        'POS.store.User',
        'POS.view.user.Add',
        'POS.view.user.Edit',
        'POS.view.user.Search',
        'POS.view.user.ListController'
    ],

    autoScroll: true,
    columnLines: true,
    closable: true,
    multiColumnSort: true,
    selModel : {
        selType   : 'checkboxmodel',
        checkOnly : true
    },
    stripeRows: true,

    initComponent: function() {
        this.title = '<i class="fa fa-user glyph"></i> User';

        var store = POS.app.getStore('User');
        this.store = store;

        this.columns = [
            {header: 'id', dataIndex:'id', hidden:true},
            {header: 'Jabatan', dataIndex: 'role', width:100},
            {header: 'User ID', dataIndex: 'user', width:100},
            {header: 'Nama', dataIndex: 'name', width:150},
            {header: 'Alamat', dataIndex: 'address', width:175},
            {header: 'Telp', dataIndex: 'phone', width:150}
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
                text:'<i class="fa fa-key glyph"></i> Reset Password',
                reference: 'resetPassword',
                handler: 'resetPassword',
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