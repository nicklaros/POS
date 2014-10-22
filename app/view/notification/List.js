Ext.define('POS.view.notification.List' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.list-notification',
    id: 'list-notification',
    controller: 'list-notification',

    requires: [
        'POS.fn.Notification',
        'POS.custom.grid.Notification',
        'POS.view.notification.ListController'
    ],

    layout: 'anchor',
	autoScroll: true,
    autoShow: true,
    bodyStyle: {
        'background-color': '#e9eaed',
        border: '0 !important'
    },
    cls: 'window',
    constrain: true,
    header: false,
    modal: true,
    resizable: false,
    
    padding: 0,
    width: 600,

    initComponent: function(){
        this.dockedItems = [{
            xtype: 'container',
            dock: 'top',
            layout: 'hbox',
            cls: 'panel-header window-header',
            style: {
                'border-bottom-width': '1px !important'
            },
            anchor: '100%',
            items: [{
                xtype: 'container',
                html: '<i class="fa fa-bell-o glyph"></i> 0 Pemberitahuan',
                bind: {
                    html: '<i class="fa fa-bell-o glyph"></i> {notificationCount} Pemberitahuan'
                },
                flex: 1
            },{
                xtype: 'buttonsegment',
                items: [{
                    text: '<i class="fa fa-trash-o glyph"></i> Bersihkan',
                    handler: 'clear'
                },{
                    text: 'x',
                    handler: 'close'
                }]
            }]
        }];
        
        this.items = [{
            xtype: 'grid-notification'
        }];

        this.maxHeight = Ext.getBody().getViewSize().height;

        this.callParent(arguments);
    }
});