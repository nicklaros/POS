Ext.define('POS.view.purchase.SearchController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.search-purchase',

    control: {
        '#': {
            boxready: function(panel){
                var params = POS.app.getStore('Purchase').getProxy().extraParams;

                this.lookupReference('form').getForm().setValues(params);

                var supplier = this.lookupReference('supplier');
                setTimeout(function(){
                    supplier.focus();
                }, 10);
            }
        },
        'textfield[searchOnEnter = true]': {
            specialkey: function(f, e){
                if(e.getKey() == e.ENTER) this.search();
            }
        }
    },

    cancel: function(){
        this.getView().close();
    },

    search: function(){
        var panel = this.getView(),
            params = this.lookupReference('form').getValues();

        for (var i in params) {
            if (params[i] === null || params[i] === "") delete params[i];
        }

        POS.app.getStore('Purchase').search(params);
        panel.close();
    }
});
