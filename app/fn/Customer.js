Ext.define('POS.fn.Customer', {
    singleton: true,

    showCredit: function(customerId){
        var customerDetail = Ext.ComponentQuery.query('customer-detail')[0];
        
        if (customerDetail) customerDetail.close();
        
        POS.fn.App.showSecondPartyCredit(customerId);
    },

    showDebit: function(customerId){
        var customerDetail = Ext.ComponentQuery.query('customer-detail')[0];
        
        if (customerDetail) customerDetail.close();
        
        POS.fn.App.showSecondPartyDebit(customerId);
    }
    
});