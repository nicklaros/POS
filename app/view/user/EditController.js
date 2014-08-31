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
        Ext.fn.WebSocket.monitor(
            Ext.ws.Main.on('user/loadFormEdit', function(websocket, data){
                Ext.fn.App.setLoading(false);
                if (data.success){
                    form.getForm().setValues(data.root);
                }else{
                    panel.close();
                    Ext.fn.App.notification('Ups', data.errmsg);
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
            Ext.fn.WebSocket.monitor(
                Ext.ws.Main.on('user/update', function(websocket, data){
                    Ext.fn.App.setLoading(false);
                    if (data.success){
                        panel.close();
                        POS.app.getStore('POS.store.User').load();
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
