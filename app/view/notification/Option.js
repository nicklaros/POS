Ext.define('POS.view.notification.Option' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.notification-option',
    id: 'notification-option',
    controller: 'notification-option',

    requires: [
        'POS.custom.grid.NotificationOption',
        'POS.store.notificationoption.Price',
        'POS.view.notification.AddOption',
        'POS.view.notification.OptionController'
    ],

    layout: 'accordion',
    
    autoShow: true,
    constrain: true,
    resizable: false,
    
    bodyPadding: 0,
    width: 350,

    initComponent: function(){
        this.title = '<i class="fa fa-bell-o glyph"></i> Pengaturan Pemberitahuan';

        this.items = [{
            xtype: 'grid-notification-option',
            title: 'Perubahan Harga',
            itemId: 'option-price',
            store: POS.app.getStore('notificationoption.Price'),
            dockedItems: [{
                xtype: 'toolbar',
                dock: 'top',
                ui: 'footer',
                items: [{
                    text: '<i class="fa fa-plus-square"></i>',
                    reference: 'addOptionPrice',
                    handler: 'addOptionPrice'
                },{
                    text: '<i class="fa fa-minus-square"></i>',
                    reference: 'subOptionPrice',
                    handler: 'subOptionPrice',
                    disabled: true
                }]
            }]
        }];

        this.maxHeight = Ext.getBody().getViewSize().height;

        this.callParent(arguments);
    }
});