Ext.define('POS.store.chart.transaction.Last30Days', {
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
                read: 'chart/last30DaysTransaction'
            },
            reader: {
                type: 'json',
                rootProperty: 'data'
            }
        });
    },
    
    listeners: {
        'beforepush': function(store){
            store.removeAll();
        }
    }
    
});