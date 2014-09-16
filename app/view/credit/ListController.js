Ext.define('POS.view.credit.ListController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.list-credit',

    control: {
        '#': {
            boxready: function(panel){
                
            },
            selectionchange: function(sm, selected){
                var salesDetail = this.lookupReference('sales_detail'),
                    pay         = this.lookupReference('pay');

                salesDetail.setDisabled(selected.length !== 1);
                pay.setDisabled(selected.length !== 1 || selected[0].get('balance') <= 0);
            },
            celldblclick: 'salesDetail'
        }
    },
    
    listPayment: function(){
        var panel = Ext.fn.App.newTab('list-credit-payment');
        panel.getStore().search({});
    },
    
    pay: function(){
        var rec     = this.getView().getSelectionModel().getSelection()[0],
            params  = {
                credit_id: rec.get('id')
            };
        
        var panel = Ext.fn.App.window('pay-credit');
        panel.getController().load(params);
    },

    salesDetail: function(){
        var rec     = this.getView().getSelectionModel().getSelection()[0],
            params  = {
                id: rec.get('sales_id')
            };

        var detail = Ext.fn.App.window('detail-sales');
        detail.getController().load(params);
    },
    
    search: function(){
        Ext.fn.App.window('search-credit');
    },
    
    reset: function(){
        this.getView().getStore().search({});
    }
});
