Ext.define('POS.store.combo.Supplier', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Supplier',
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'combo/supplier'
            },
            reader: {
                type: 'json',
                rootProperty: 'data'
            }
        });
    }
})