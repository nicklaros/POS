Ext.define('POS.view.user.Search' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.search-user',
    id: 'search-user',
    controller: 'search-user',

    requires: [
        'POS.custom.field.ComboRole',
        'POS.store.User',
        'POS.view.user.SearchController'
    ],

    autoShow: true,
    constrain: true,
    layout: 'anchor',
    resizable: false,
    width: 300,

    initComponent: function(){
        this.title = '<i class="fa fa-align-left glyph"></i> Pencarian User';

        this.items = [{
            xtype: 'form',
            reference: 'form',
            bodyPadding: 10,
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Nama',
                name: 'name',
                reference: 'name',
                emptyText: EMPTY_TEXT_0,
                anchor: '100%'
            },{
                xtype: 'combo-role',
                fieldLabel: 'Level',
                name: 'role',
                emptyText: EMPTY_TEXT_0,
                anchor: '100%',
                listeners: {
                    change: 'levelChange'
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