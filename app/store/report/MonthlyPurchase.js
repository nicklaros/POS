Ext.define('POS.store.report.MonthlyPurchase', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Purchase',
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'report/monthlyPurchase'
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