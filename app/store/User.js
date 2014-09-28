Ext.define('POS.store.User', {
    extend: 'Ext.data.Store',
    model: 'POS.model.User',

    remoteSort: true,
    pageSize: 100,

    sorters: [{
        property: 'id',
        direction: 'DESC'
    }],
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'user/read'
            },
            reader: {
                type: 'json',
                rootProperty: 'data'
            }
        });
    },

    search: function(params){
        this.getProxy().extraParams = params;
        this.loadPage(1);
    }
});