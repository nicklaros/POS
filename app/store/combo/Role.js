Ext.define('POS.store.combo.Role', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Role',
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'combo/role'
            },
            reader: {
                type: 'json',
                rootProperty: 'data'
            }
        });
    }
})