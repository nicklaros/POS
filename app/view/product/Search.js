Ext.define('POS.view.product.Search' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.search-product',
    id: 'search-product',
    controller: 'search-product',

    requires: [
        'POS.view.product.SearchController'
    ],

    autoShow: true,
    constrain: true,
    layout: 'anchor',
    resizable: false,
    width: 300,

    initComponent: function(){
        this.title = '<i class="fa fa-file-archive-o glyph"></i> Pencarian Produk';

        this.items = [{
            xtype: 'form',
            reference: 'form',
            bodyPadding: 10,
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Kode / Nama Produk',
                name: 'code_or_name',
                reference: 'code_or_name',
                emptyText: EMPTY_TEXT_0,
                searchOnEnter: true,
                selectOnFocus: true,
                anchor: '100%'
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