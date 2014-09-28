Ext.define('POS.view.customer.Search' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.search-customer',
    id: 'search-customer',
    controller: 'search-customer',

    requires: [
        'POS.view.customer.SearchController'
    ],

    layout: 'vbox',
    
    autoShow: true,
    constrain: true,
    resizable: false,
    width: 300,

    initComponent: function(){
        this.title = '<i class="fa fa-group glyph"></i> Pencarian Pelanggan';

        this.items = [{
            xtype: 'form',
            bodyPadding: 10,
            width: '100%',
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Nama Pelanggan',
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