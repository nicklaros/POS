Ext.define('POS.store.combo.Unit', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Unit',
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'combo/unit'
            },
            reader: {
                type: 'json',
                rootProperty: 'data'
            }
        });
    }
})