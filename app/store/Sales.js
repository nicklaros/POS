Ext.define('POS.store.Sales', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Sales',

    remoteSort: true,
    pageSize: 100,

    sorters: [{
        property: 'date',
        direction: 'DESC'
    }],
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'sales/read'
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