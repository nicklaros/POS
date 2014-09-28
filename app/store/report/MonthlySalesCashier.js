Ext.define('POS.store.report.MonthlySalesCashier', {
    extend: 'Ext.data.Store',
    fields: [
        {name: 'cashier_id',        type: 'int'},
        {name: 'cashier_name',      type: 'string'},
        {name: 'sales_amount',      type: 'int'},
        {name: 'sales_total',       type: 'int'}
    ],
    
    init: function(){
        this.setProxy({
            type: 'websocket',
            storeId: this.getStoreId(),
            websocket: Ext.ws.Main,
            api: {
                read: 'report/monthlySalesCashier'
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