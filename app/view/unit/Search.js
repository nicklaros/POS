Ext.define('POS.view.unit.Search' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.search-unit',
    id: 'search-unit',
    controller: 'search-unit',

    requires: [
        'POS.view.unit.SearchController'
    ],

    layout: 'vbox',
    
    autoShow: true,
    constrain: true,
    resizable: false,
    width: 300,

    initComponent: function(){
        this.title = '<i class="fa fa-cubes glyph"></i> Pencarian Satuan';

        this.items = [{
            xtype: 'form',
            bodyPadding: 10,
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Nama Satuan',
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