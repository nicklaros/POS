Ext.define('POS.view.debit.PayController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.pay-debit',

    control: {
        'textfield[saveOnEnter = true]': {
            specialkey: function(f, e){
                if(e.getKey() == e.ENTER) this.save();
            }
        }
    },

    close: function(){
        this.getView().close();
    },

    load: function(params){
        var me     = this,
            panel  = me.getView(),
            form   = panel.down('form');

        POS.fn.App.setLoading(true);
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('debit/loadFormPay', function(websocket, result){
                clearTimeout(monitor);
                POS.fn.App.setLoading(false);
                POS.app.getStore('Debit').load();
                POS.app.getStore('DebitPayment').load();
                if (result.success){
                    panel.show();

                    form.getForm().setValues(result.data);
                    
                    var cashier = Ext.create('POS.model.Cashier', {
                        id: Ext.main.ViewModel.data.current_user.id,
                        name: Ext.main.ViewModel.data.current_user.name
                    });

                    me.lookupReference('cashier').setValue(cashier); 

                    setTimeout(function(){
                        me.lookupReference('paid').focus(true);
                    }, 10);
                }else{
                    panel.close();
                    POS.fn.App.notification('Ups', result.errmsg);
                }
            }, this, {
                single: true,
                destroyable: true
            }),
            panel
        );
        Ext.ws.Main.send('debit/loadFormPay', params);
    },

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values = form.getValues();

            panel.setLoading(true);
            var monitor = POS.fn.WebSocket.monitor(
                Ext.ws.Main.on('debit/pay', function(websocket, result){
                    clearTimeout(monitor);
                    panel.setLoading(false);
                    if (result.success){
                        panel.close();
                    }else{
                        POS.fn.App.notification('Ups', result.errmsg);
                    }
                    POS.app.getStore('Debit').load();
                    POS.app.getStore('DebitPayment').load();
                }, this, {
                    single: true,
                    destroyable: true
                }),
                panel,
                false
            );
            Ext.ws.Main.send('debit/pay', values);
        }
    },
    
    setBalance: function(){
        var debit   = this.lookupReference('debit'),
            paid    = this.lookupReference('paid'),
            balance = this.lookupReference('balance'),
            result  = paid.getSubmitValue() - debit.getSubmitValue();
        
        balance.setValue(result);
        
        balance.setFieldStyle(result < 0 ? FIELD_MINUS : FIELD_PLUS);
    }
});
