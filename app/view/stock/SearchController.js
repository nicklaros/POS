Ext.define('POS.view.stock.SearchController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.searchstock',

    control: {
        '#': {
            boxready: function(panel){
                var params = POS.app.getStore('POS.store.Stock').getProxy().extraParams;

                this.lookupReference('form').getForm().setValues(params);

                var nama = this.lookupReference('nama');
                setTimeout(function(){
                    nama.focus()
                }, 10);
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

        POS.app.getStore('POS.store.Stock').search(params);
        panel.close();
    },

    specialkey: function(f, e){
        if(e.getKey() == e.ENTER) this.search();
    }
});
