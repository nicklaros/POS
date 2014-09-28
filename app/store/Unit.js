Ext.define('POS.store.Unit', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Unit',

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
                read: 'unit/read'
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