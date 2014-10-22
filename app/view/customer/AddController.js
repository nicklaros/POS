Ext.define('POS.view.customer.AddController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.add-customer',

    control: {
        '#': {
            boxready: function(){
                var name = this.lookupReference('name');
                setTimeout(function(){
                    name.focus();
                }, 10);
            }
        },
        'textfield[tabOnEnter = true]': {
            specialkey: function(field, e){
                if(e.getKey() == e.ENTER) field.next('field').focus();
            }
        },
        'textfield[saveOnEnter = true]': {
            specialkey: function(field, e){
                field.fireEvent('blur', field);
                if(e.getKey() == e.ENTER) this.save();
            }
        }
    },

    close: function(){
        this.getView().close();
    },

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values = form.getValues();

            panel.setLoading(true);
            var monitor = POS.fn.WebSocket.monitor(
                Ext.ws.Main.on('customer/create', function(websocket, result){
                    clearTimeout(monitor);
                    panel.setLoading(false);
                    if (result.success){
                        panel.close();
                        POS.app.getStore('Customer').load();
                        
                        var bindCombo = Ext.getCmp(panel.bindCombo);
                        
                        if (!Ext.isEmpty(bindCombo) && (bindCombo.xtype == 'combo-customer')) {                            
                            var customer = Ext.create('POS.model.Customer', result.data);
                            
                            bindCombo.getStore().add(customer);
                            
                            bindCombo.select(customer);
                            
                            bindCombo.fireEvent('select', bindCombo, [customer]);
                        }
                    }else{
                        POS.fn.App.notification('Ups', result.errmsg);
                        
                        var name = this.lookupReference('name');
                        setTimeout(function(){
                            name.focus();
                        }, 10);
                    }
                }, this, {
                    single: true,
                    destroyable: true
                }),
                panel,
                false
            );
            Ext.ws.Main.send('customer/create', values);
        }
    }
});
