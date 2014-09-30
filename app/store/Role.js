Ext.define('POS.store.Role', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Role',

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
                read: 'role/read'
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