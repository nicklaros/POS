Ext.define('POS.view.stock.Search' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.search-stock',
    id: 'search-stock',
    controller: 'search-stock',

    requires: [
        'POS.view.stock.SearchController'
    ],

    autoShow: true,
    constrain: true,
    layout: 'anchor',
    resizable: false,
    width: 300,

    initComponent: function(){
        this.title = '<i class="fa fa-align-left glyph"></i> Pencarian Stock';

        this.items = [{
            xtype: 'form',
            reference: 'form',
            bodyPadding: 10,
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Nama',
                name: 'nama',
                reference: 'nama',
                emptyText: EF0,
                anchor: '100%',
                listeners: {
                    specialkey: 'specialkey'
                }
            },{
                xtype: 'textfield',
                fieldLabel: 'Kode Barang',
                name: 'kode',
                emptyText: EF0,
                anchor: '100%',
                listeners: {
                    specialkey: 'specialkey'
                }
            }]
        }];

        this.dockedItems = [{
            xtype: 'toolbar',
            dock: 'top',
            ui: 'footer',
            items: [{
                text: '<i class="fa fa-search glyph"></i> Cari',
                handler: 'search'
            },{
                text: '<i class="fa fa-undo glyph"></i> Batal',
                handler: 'cancel'
            }]
        }];

        this.callParent(arguments);
    }
});