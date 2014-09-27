Ext.define('POS.store.combo.SecondParty', {
    extend: 'Ext.data.Store',
    model: 'POS.model.SecondParty',
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'combo/secondParty'
            },
            reader: {
                type: 'json',
                rootProperty: 'data'
            }
        });
    }
})