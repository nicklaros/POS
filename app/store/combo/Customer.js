Ext.define('POS.store.combo.Customer', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Customer',
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'combo/customer'
            },
            reader: {
                type: 'json',
                rootProperty: 'data'
            }
        });
    }
})