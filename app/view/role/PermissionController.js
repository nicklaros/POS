Ext.define('POS.view.role.PermissionController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.role-permission',

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
            Ext.ws.Main.on('role/loadPermission', function(websocket, result){
                clearTimeout(monitor);
                POS.fn.App.setLoading(false);
                if (result.success){
                    panel.show();
                    
                    form.getForm().setValues(result.data);
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
        Ext.ws.Main.send('role/loadPermission', params);
    },

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values = form.getValues();

            panel.setLoading(true);
            var monitor = POS.fn.WebSocket.monitor(
                Ext.ws.Main.on('role/savePermission', function(websocket, data){
                    clearTimeout(monitor);
                    panel.setLoading(false);
                    if (data.success){
                        panel.close();
                    }else{
                        POS.fn.App.notification('Ups', data.errmsg);
                    }
                }, this, {
                    single: true,
                    destroyable: true
                }),
                panel,
                false
            );
            Ext.ws.Main.send('role/savePermission', values);
        }
    }
});
