Ext.define('POS.store.combo.Product', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Product',
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'combo/product'
            },
            reader: {
                type: 'json',
                rootProperty: 'data'
            }
        });
    }
})