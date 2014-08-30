Ext.define('POS.view.user.SearchController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.searchuser',

    control: {
        '#': {
            boxready: function(panel){
                var params = POS.app.getStore('POS.store.User').getProxy().extraParams;

                this.lookupReference('form').getForm().setValues(params);

                var nama = this.lookupReference('nama');
                setTimeout(function(){
                    nama.focus()
                }, 10);
            }
        },
        'textfield': {
            specialkey: function(f, e){
                if(e.getKey() == e.ENTER) this.search();
            }
        }
    },

    cancel: function(){
        this.getView().close();
    },

    levelChange: function(combo){
        if (combo.getValue() == null) combo.reset();
    },

    search: function(){
        var panel = this.getView(),
            params = this.lookupReference('form').getValues();

        for (var i in params) {
            if (params[i] === null || params[i] === "") delete params[i];
        }

        POS.app.getStore('POS.store.User').search(params);
        panel.close();
    }
});
