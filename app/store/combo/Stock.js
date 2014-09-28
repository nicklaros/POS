Ext.define('POS.store.combo.Stock', {
    extend: 'Ext.data.Store',
    model: 'POS.model.combo.Stock',
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'combo/stock'
            },
            reader: {
                type: 'json',
                rootProperty: 'data'
            }
        });
    }
})