Ext.define('POS.store.chart.transaction.customer.Last7Months', {
    extend: 'Ext.data.Store',
    fields: [
        {name: 'month',     type: 'date',   format: 'Y-m-d'},
        {name: 'sales',     type: 'int'},
        {name: 'purchase',  type: 'int'}
    ],
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'customer/last7MonthsTransactions'
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