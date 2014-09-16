Ext.define('POS.view.credit.ListPaymentController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.list-credit-payment',

    control: {
        '#': {
            boxready: function(panel){
                
            }
        }
    },
    
    search: function(){
        Ext.fn.App.window('search-credit-payment');
    },
    
    reset: function(){
        this.getView().getStore().search({});
    }
});
