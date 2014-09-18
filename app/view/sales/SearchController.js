Ext.define('POS.view.sales.SearchController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.search-sales',

    control: {
        '#': {
            boxready: function(panel){
                var params = POS.app.getStore('Sales').getProxy().extraParams;

                this.lookupReference('form').getForm().setValues(params);

                var id = this.lookupReference('id');
                setTimeout(function(){
                    id.focus();
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

        POS.app.getStore('Sales').search(params);
        panel.close();
    }
});
