Ext.define('POS.view.main.MainController', {
    extend: 'Ext.app.ViewController',

    requires: [
        'Ext.fn.App',
        'Ext.MessageBox'
    ],

    alias: 'controller.main',

    control: {
        '#': {
            boxready: function(){
                // Create global variable container
                Ext.main = {};

                // Create array container for storing currently visible window
                Ext.main.Windows = [];

                Ext.main.View = this.getView();
                Ext.main.ViewModel = Ext.main.View.getViewModel();
            }
        }
    }

});
