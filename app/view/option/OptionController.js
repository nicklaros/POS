Ext.define('POS.view.option.OptionController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.app-option',

    control: {
        '#': {
            boxready: function(){
                
            }
        }
    },

    close: function(){
        this.getView().close();
    }
    
});