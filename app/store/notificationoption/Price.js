Ext.define('POS.store.notificationoption.Price', {
    extend: 'Ext.data.Store',
    model: 'POS.model.NotificationOption',
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'notification/loadOptionPrice'
            },
            reader: {
                type: 'json',
                rootProperty: 'data'
            }
        });
    }
})