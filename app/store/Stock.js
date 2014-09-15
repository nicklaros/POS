Ext.define('POS.store.Stock', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Stock',

    remoteSort: true,
    pageSize: 100,

    sorters: [{
        property: 'product',
        direction: 'ASC'
    }],
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'stock/read'
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