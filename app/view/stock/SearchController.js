Ext.define('POS.view.stock.SearchController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.search-stock',

    control: {
        '#': {
            boxready: function(panel){
                var params = POS.app.getStore('Stock').getProxy().extraParams;

                this.lookupReference('form').getForm().setValues(params);

                var codeorName = this.lookupReference('code_or_name');
                setTimeout(function(){
                    codeorName.focus()
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

        POS.app.getStore('Stock').search(params);
        panel.close();
    }
});
