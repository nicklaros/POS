Ext.define('POS.store.chart.transaction.Monthly', {
    extend: 'Ext.data.Store',
    fields: [
        {name: 'date',      type: 'date',   format: 'Y-m-d'},
        {name: 'sales',     type: 'int'},
        {name: 'purchase',  type: 'int'}
    ],
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'chart/monthlyTransaction'
            },
            reader: {
                type: 'json',
                rootProperty: 'data'
            }
        });
    }
    
});