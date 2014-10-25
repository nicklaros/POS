Ext.define('POS.view.role.List' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.list-role',
    controller: 'list-role',

    requires: [
        'Ext.ux.container.ButtonSegment',
        'POS.store.Role',
        'POS.view.notification.Option',
        'POS.view.role.Add',
        'POS.view.role.Edit',
        'POS.view.role.ListController',
        'POS.view.role.Permission',
        'POS.view.role.Search'
    ],

    autoScroll: true,
    columnLines: true,
    closable: true,
    selType: 'checkboxmodel',
    stripeRows: true,

    initComponent: function() {
        this.title = '<i class="fa fa-briefcase glyph"></i> Jabatan';

        var store = POS.app.getStore('Role');
        this.store = store;

        this.columns = [
            {header: 'Jabatan', dataIndex: 'name', width: 350}
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
                text: '<i class="fa fa-edit glyph"></i> Ubah',
                reference: 'edit',
                handler: 'edit',
                disabled: true
            },{
                text: '<i class="fa fa-check-square-o glyph"></i> Hak Akses',
                reference: 'permission',
                handler: 'permission',
                disabled: true
            },{
                text: '<i class="fa fa-trash-o glyph"></i> Hapus',
                reference: 'delete',
                handler: 'remove',
                disabled: true
            },{
                text: '<i class="fa fa-bell-o glyph"></i> Pemberitahuan',
                reference: 'notificationOption',
                handler: 'notificationOption'
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