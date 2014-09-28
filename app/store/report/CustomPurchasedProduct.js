Ext.define('POS.store.report.CustomPurchasedProduct', {
    extend: 'Ext.data.Store',
    model: 'POS.model.report.PurchasedProduct',

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
                read: 'report/CustomPurchasedProduct'
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