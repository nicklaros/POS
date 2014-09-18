Ext.define('POS.store.Customer', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Customer',

    remoteSort: true,
    pageSize: 100,

    sorters: [{
        property: 'name',
        direction: 'ASC'
    }],
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'customer/read'
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