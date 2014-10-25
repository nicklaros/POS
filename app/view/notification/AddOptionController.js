Ext.define('POS.view.notification.AddOptionController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.add-notification-option',

    control: {
        '#': {
            boxready: function(){
                var role = this.lookupReference('role');
                
                setTimeout(function(){
                    role.focus();
                }, 10);
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
            var values = form.getValues(),
                action = '',
                store  = '';
            
            switch ( panel.notificationType ) {
                case 'price':
                    action = 'notification/addOptionPrice';
                    store  = 'notificationoption.Price';
            }

            panel.setLoading(true);
            var monitor = POS.fn.WebSocket.monitor(
                Ext.ws.Main.on(action, function(websocket, result){
                    clearTimeout(monitor);
                    panel.setLoading(false);
                    if (result.success){
                        panel.close();
                    }else{
                        POS.fn.App.notification('Ups', result.errmsg);
                    }
                    POS.app.getStore(store).load();
                }, this, {
                    single: true,
                    destroyable: true
                }),
                panel,
                false
            );
            Ext.ws.Main.send(action, values);
        }
    }
});
