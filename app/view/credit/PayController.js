Ext.define('POS.view.credit.PayController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.pay-credit',

    control: {
        'textfield[saveOnEnter = true]': {
            specialkey: function(f, e){
                if(e.getKey() == e.ENTER) this.save();
            }
        },
        'textfield[name = paid]': {
            change: function(){
                this.setBalance();
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
            Ext.ws.Main.on('credit/loadFormPay', function(websocket, result){
                clearTimeout(monitor);
                POS.fn.App.setLoading(false);
                POS.app.getStore('Credit').load();
                POS.app.getStore('CreditPayment').load();
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
        Ext.ws.Main.send('credit/loadFormPay', params);
    },

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values = form.getValues();

            panel.setLoading(true);
            var monitor = POS.fn.WebSocket.monitor(
                Ext.ws.Main.on('credit/pay', function(websocket, result){
                    clearTimeout(monitor);
                    panel.setLoading(false);
                    
                    POS.app.getStore('Credit').load();
                    POS.app.getStore('CreditPayment').load();
                    
                    if (result.success){
                        panel.close();
                    }else{
                        POS.fn.App.notification('Ups', result.errmsg);
                    }
                }, this, {
                    single: true,
                    destroyable: true
                }),
                panel,
                false
            );
            Ext.ws.Main.send('credit/pay', values);
        }
    },
    
    setBalance: function(){
        var credit  = this.lookupReference('credit'),
            paid    = this.lookupReference('paid'),
            balance = this.lookupReference('balance'),
            result  = paid.getSubmitValue() - credit.getSubmitValue();
        
        balance.setValue(result);
        
        balance.setFieldStyle(result < 0 ? FIELD_MINUS : FIELD_PLUS);
    }
});
