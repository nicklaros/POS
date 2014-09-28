Ext.define('POS.view.unit.List' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.list-unit',
    controller: 'list-unit',

    requires: [
        'Ext.ux.container.ButtonSegment',
        'POS.store.Unit',
        'POS.view.unit.Add',
        'POS.view.unit.Edit',
        'POS.view.unit.ListController',
        'POS.view.unit.Search'
    ],

    autoScroll: true,
    columnLines: true,
    closable: true,
    selType: 'checkboxmodel',
    stripeRows: true,

    initComponent: function() {
        this.title = '<i class="fa fa-cubes glyph"></i> Satuan';

        var store = POS.app.getStore('Unit');
        this.store = store;

        this.columns = [
            {header: 'Satuan', dataIndex: 'name', width: 350}
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