Ext.define('POS.store.combo.Cashier', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Cashier',
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'combo/cashier'
            },
            reader: {
                type: 'json',
                rootProperty: 'data'
            }
        });
    }
})