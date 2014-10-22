Ext.define('POS.view.secondparty.AddController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.add-second-party',

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
                Ext.ws.Main.on('secondParty/create', function(websocket, result){
                    clearTimeout(monitor);
                    panel.setLoading(false);
                    if (result.success){
                        panel.close();
                        
                        // check newly created second party type then load store accordingly
                        if (result.data.type == 'Customer'){
                            POS.app.getStore('Customer').load();
                        }else{
                            POS.app.getStore('Supplier').load();
                        }
                        
                        var bindCombo = Ext.getCmp(panel.bindCombo);
                        
                        if (!Ext.isEmpty(bindCombo) && (bindCombo.xtype == 'combo-second-party')) {                            
                            var secondParty = Ext.create('POS.model.SecondParty', result.data);
                            
                            bindCombo.getStore().add(secondParty);
                            
                            bindCombo.select(secondParty);
                            
                            bindCombo.fireEvent('select', bindCombo, [secondParty]);
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
            Ext.ws.Main.send('secondParty/create', values);
        }
    }
});
