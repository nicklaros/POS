Ext.define('POS.view.user.SearchController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.search-user',

    control: {
        '#': {
            boxready: function(panel){
                var params = POS.app.getStore('User').getProxy().extraParams;

                this.lookupReference('form').getForm().setValues(params);

                var name = this.lookupReference('name');
                setTimeout(function(){
                    name.focus()
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

        POS.app.getStore('User').search(params);
        panel.close();
    }
});
