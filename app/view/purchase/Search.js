Ext.define('POS.view.purchase.Search' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.search-purchase',
    id: 'search-purchase',
    controller: 'search-purchase',

    requires: [
        'POS.custom.field.Date',
        'POS.view.purchase.SearchController'
    ],

    autoShow: true,
    constrain: true,
    layout: 'anchor',
    resizable: false,
    width: 300,

    initComponent: function(){
        this.title = '<i class="fa fa-truck glyph"></i> Pencarian Pembelian';

        this.items = [{
            xtype: 'form',
            reference: 'form',
            bodyPadding: 10,
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Supplier',
                name: 'supplier',
                reference: 'supplier',
                emptyText: EMPTY_TEXT_0,
                searchOnEnter: true,
                selectOnFocus: true,
                anchor: '100%'
            },{
                xtype: 'field-date',
                fieldLabel: 'Mulai Tanggal',
                name: 'start_date',
                emptyText: EMPTY_TEXT_0,
                searchOnEnter: true,
                selectOnFocus: true,
                anchor: '100%'
            },{
                xtype: 'field-date',
                fieldLabel: 'Hingga Tanggal',
                name: 'until_date',
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