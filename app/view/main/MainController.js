Ext.define('POS.view.main.MainController', {
    extend: 'Ext.app.ViewController',

    requires: [
        'Ext.fn.App',
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
            &&
            Ext.isEmpty(Ext.ComponentQuery.query('add-sales'))
            &&
            Ext.isEmpty(Ext.ComponentQuery.query('add-sales-detail'))
            &&
            Ext.isEmpty(Ext.ComponentQuery.query('edit-sales'))
            &&
            Ext.isEmpty(Ext.ComponentQuery.query('edit-sales-detail'))
            &&
            Ext.isEmpty(Ext.ComponentQuery.query('add-purchase'))
            &&
            Ext.isEmpty(Ext.ComponentQuery.query('add-purchase-detail'))
            &&
            Ext.isEmpty(Ext.ComponentQuery.query('edit-purchase'))
            &&
            Ext.isEmpty(Ext.ComponentQuery.query('edit-purchase-detail'))
        );
    },
    
    keyMap: function(panel){
        var me = this;
        
        new Ext.util.KeyMap({
            target: Ext.getDoc(),
            binding: [{
                key: 112, // F1 ---> dedicated for add-sales module
                defaultEventAction: 'preventDefault',
                fn: function(){ 
                    if (!me.isKeyBlocked()) {
                        var addSales = Ext.fn.App.window('add-sales');
                        
                        addSales.getController().add();
                    }
                }
            },{
                key: 113, // F2 ---> dedicated for add-purchase module
                defaultEventAction: 'preventDefault',
                fn: function(){ 
                    if (!me.isKeyBlocked()) {
                        var addPurchase = Ext.fn.App.window('add-purchase');

                        addPurchase.getController().add();
                    }
                }
            }]
        });
    },
    
    openNotification: function(){
        Ext.widget('list-notification');
    }

});
