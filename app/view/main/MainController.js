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
            }
        }
    },
    
    keyMap: function(panel){
        var me = this;
        
        new Ext.util.KeyMap({
            target: panel.getEl(),
            binding: [{
                key: 112, // F1
                defaultEventAction: 'preventDefault',
                fn: function(){ 
                    // lets rock it
                    if (Ext.isEmpty(Ext.ComponentQuery.query('list-sales')[0])) {
                        // if list-sales is not open then open it
                        Ext.fn.App.mnListSales();
                    } else if (
                        Ext.isEmpty(Ext.ComponentQuery.query('add-sales')[0])
                        &&
                        Ext.isEmpty(Ext.ComponentQuery.query('edit-sales')[0])
                    ) {
                        // if list-sales opened but add-sales is not open then open it
                        Ext.fn.App.window('add-sales');
                    }
                }
            }]
        });
    }

});
