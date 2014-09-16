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

        Ext.fn.App.setLoading(true);
        var monitor = Ext.fn.WebSocket.monitor(
            Ext.ws.Main.on('credit/loadFormPay', function(websocket, result){
                clearTimeout(monitor);
                Ext.fn.App.setLoading(false);
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
                    POS.app.getStore('Credit').load();
                    Ext.fn.App.notification('Ups', result.errmsg);
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
            var monitor = Ext.fn.WebSocket.monitor(
                Ext.ws.Main.on('credit/pay', function(websocket, result){
                    clearTimeout(monitor);
                    panel.setLoading(false);
                    if (result.success){
                        panel.close();
                    }else{
                        Ext.fn.App.notification('Ups', result.errmsg);
                    }
                    POS.app.getStore('Credit').load();
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
