Ext.define('POS.store.Notification', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Notification',

    remoteSort: true,
    pageSize: 100,

    sorters: [{
        property: 'time',
        direction: 'DESC'
    }],
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'notification/read'
            },
            reader: {
                type: 'json',
                rootProperty: 'data'
            }
        });
    },
    
    listeners: {
        'clear': function(store){
            Ext.main.ViewModel.set('notificationCount', 0);
        },
        'load': function(store){
            Ext.main.ViewModel.set('notificationCount', store.count());
        },
        'remove': function(store){
            Ext.main.ViewModel.set('notificationCount', store.count());
        }
    }
});