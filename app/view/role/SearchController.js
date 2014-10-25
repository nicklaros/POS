Ext.define('POS.view.role.SearchController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.search-role',

    control: {
        '#': {
            boxready: function(panel){
                var params = POS.app.getStore('Role').getProxy().extraParams;

                panel.down('form').getForm().setValues(params);

                var name = this.lookupReference('name');
                setTimeout(function(){
                    name.focus()
                }, 10);
            }
        },
        'textfield[searchOnEnter = true]': {
            specialkey: function(field, e){
                field.fireEvent('blur', field);
                if(e.getKey() == e.ENTER) this.search();
            }
        }
    },

    cancel: function(){
        this.getView().close();
    },

    search: function(){
        var panel   = this.getView(),
            params  = panel.down('form').getValues();

        for (var i in params) {
            if (params[i] === null || params[i] === "") delete params[i];
        }

        POS.app.getStore('Role').search(params);
        panel.close();
    }
});
