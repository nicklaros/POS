Ext.define('Ext.fn.Customer', {
    singleton: true,

    showCredit: function(customerId){
        var customerDetail = Ext.ComponentQuery.query('customer-detail')[0];
        
        if (customerDetail) customerDetail.close();
        
        Ext.fn.App.showCustomerCredit(customerId);
    }
    
});