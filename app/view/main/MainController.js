Ext.define('POS.view.main.MainController', {
    extend: 'Ext.app.ViewController',

    requires: [
        'POS.fn.App',
        'Ext.MessageBox'
    ],

    alias: 'controller.main',

    control: {
        '#': {
            boxready: function(panel){    
                // Create global variable container
                Ext.main = {};

                // Create array container for storing currently visible window
                Ext.main.Windows = [];

                Ext.main.View = panel;
                Ext.main.ViewModel = panel.getViewModel();
                Ext.main.AppNav = Ext.ComponentQuery.query('app-nav')[0];
                Ext.main.AppTab = Ext.ComponentQuery.query('app-tab')[0];
                
                this.keyMap(panel);
                
                var user = this.lookupReference('login').down('[name = user]');
                setTimeout(function(){
                    user.focus();
                }, 10);
                
                var store = POS.app.getStore('chart.transaction.Last30Days');
                this.getView().down('chart-transaction chart').setStore(store);
                
            }
        }
    },
    
    isKeyBlocked: function(){
        return !(
            Ext.main.ViewModel.get('state') == 1
        );
    },
    
    keyMap: function(panel){
        var me      = this;
        
        new Ext.util.KeyMap({
            target: Ext.getDoc(),
            binding: [{
                key: 112, // F1 ---> dedicated for add-sales module
                defaultEventAction: 'preventDefault',
                fn: function(){ 
                    if (!me.isKeyBlocked()) {
                        var addSales = POS.fn.App.newTab('add-sales');
                    }
                }
            },{
                key: 113, // F2 ---> dedicated for add-purchase module
                defaultEventAction: 'preventDefault',
                fn: function(){ 
                    if (!me.isKeyBlocked()) {
                        var addPurchase = POS.fn.App.newTab('add-purchase');
                    }
                }
            }]
        });
    },
    
    openNotification: function(){
        Ext.widget('list-notification');
    }

});
