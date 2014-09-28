Ext.define('POS.view.user.EditController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.edit-user',

    requires: [
        'Ext.fn.Util'
    ],

    control: {
        'textfield': {
            specialkey: function(f, e){
                if(e.getKey() == e.ENTER) this.save();
            }
        }
    },

    close: function(){
        this.getView().close();
    },

    load: function(id){
        var panel = this.getView(),
            form = this.lookupReference('form');

        Ext.fn.App.setLoading(true);
        Ext.ws.Main.send('user/loadFormEdit', {id: id});
        var monitor = Ext.fn.WebSocket.monitor(
            Ext.ws.Main.on('user/loadFormEdit', function(websocket, result){
                clearTimeout(monitor);
                Ext.fn.App.setLoading(false);
                if (result.success){
                    form.getForm().setValues(result.data);
                }else{
                    panel.close();
                    Ext.fn.App.notification('Ups', result.errmsg);
                }
            }, this, {
                single: true,
                destroyable: true
            }),
            panel
        );
    },

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values = form.getValues();

            Ext.fn.App.setLoading(true);
            Ext.ws.Main.send('user/update', values);
            var monitor = Ext.fn.WebSocket.monitor(
                Ext.ws.Main.on('user/update', function(websocket, data){
                    clearTimeout(monitor);
                    Ext.fn.App.setLoading(false);
                    if (data.success){
                        panel.close();
                        POS.app.getStore('User').load();
                    }else{
                        Ext.fn.App.notification('Ups', data.errmsg);
                    }
                }, this, {
                    single: true,
                    destroyable: true
                })
            );
        }
    }
});
