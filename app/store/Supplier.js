Ext.define('POS.store.Supplier', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Supplier',

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
                read: 'supplier/read'
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