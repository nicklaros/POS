Ext.define('POS.store.DebitPayment', {
    extend: 'Ext.data.Store',
    model: 'POS.model.DebitPayment',

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
                read: 'debit/readPayment'
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