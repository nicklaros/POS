Ext.define('POS.view.user.AddController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.add-user',

    requires: [
        'Ext.fn.Util'
    ],

    control: {
        '#': {
            boxready: function(){
                var user = this.lookupReference('user');
                setTimeout(function(){
                    user.focus();
                }, 10);
            }
        },
        'textfield': {
            specialkey: function(f, e){
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

            Ext.fn.App.setLoading(true);
            Ext.ws.Main.send('user/create', values);
            var monitor = Ext.fn.WebSocket.monitor(
                Ext.ws.Main.on('user/create', function(websocket, data){
                    clearTimeout(monitor);
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
