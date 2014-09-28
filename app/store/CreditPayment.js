Ext.define('POS.store.CreditPayment', {
    extend: 'Ext.data.Store',
    model: 'POS.model.CreditPayment',

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
                read: 'credit/readPayment'
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