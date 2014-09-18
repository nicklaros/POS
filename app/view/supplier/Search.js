Ext.define('POS.view.supplier.Search' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.search-supplier',
    id: 'search-supplier',
    controller: 'search-supplier',

    requires: [
        'POS.view.supplier.SearchController'
    ],

    layout: 'vbox',
    
    autoShow: true,
    constrain: true,
    resizable: false,
    width: 300,

    initComponent: function(){
        this.title = '<i class="fa fa-building-o glyph"></i> Pencarian Supplier';

        this.items = [{
            xtype: 'form',
            bodyPadding: 10,
            width: '100%',
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Nama Supplier',
                name: 'name',
                reference: 'name',
                emptyText: EMPTY_TEXT_0,
                searchOnEnter: true,
                selectOnFocus: true,
                width: '100%'
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