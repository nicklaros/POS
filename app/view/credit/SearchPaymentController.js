Ext.define('POS.view.credit.SearchPaymentController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.search-credit-payment',

    control: {
        '#': {
            boxready: function(panel){
                var params = POS.app.getStore('CreditPayment').getProxy().extraParams;

                panel.down('form').getForm().setValues(params);

                var secondParty = this.lookupReference('second_party');
                setTimeout(function(){
                    secondParty.focus();
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
            params = panel.down('form').getValues();

        for (var i in params) {
            if (params[i] === null || params[i] === "") delete params[i];
        }

        POS.app.getStore('CreditPayment').search(params);
        panel.close();
    }
});
