Ext.define('POS.store.chart.transaction.CustomSalesVsPurchase', {
    extend: 'Ext.data.Store',
    fields: [
        {name: 'type',      type: 'string'},
        {name: 'amount',    type: 'int'}
    ],
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'chart/customSalesVsPurchase'
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