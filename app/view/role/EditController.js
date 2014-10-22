Ext.define('POS.view.role.EditController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.edit-role',

    control: {
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

    load: function(id){
        var panel   = this.getView(),
            form    = panel.down('form'),
            params  = {
                id: id
            };

        POS.fn.App.setLoading(true);
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('role/loadFormEdit', function(websocket, result){
                clearTimeout(monitor);
                POS.fn.App.setLoading(false);
                if (result.success){
                    panel.show();
                    
                    form.getForm().setValues(result.data);
                    
                    this.lookupReference('name').focus();
                }else{
                    panel.close();
                    POS.fn.App.notification('Ups', result.errmsg);
                }
            }, this, {
                single: true,
                destroyable: true
            }),
            panel,
            true
        );
        Ext.ws.Main.send('role/loadFormEdit', params);
    },

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values = form.getValues();

            panel.setLoading(true);
            var monitor = POS.fn.WebSocket.monitor(
                Ext.ws.Main.on('role/update', function(websocket, data){
                    clearTimeout(monitor);
                    panel.setLoading(false);
                    if (data.success){
                        panel.close();
                        
                        POS.app.getStore('Role').load();
                    }else{
                        POS.fn.App.notification('Ups', data.errmsg);
                        
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
            Ext.ws.Main.send('role/update', values);
        }
    }
});
