Ext.define('Ext.fn.Notification', {
    singleton: true,
    
    checkProductPrice: function(productId){
        Ext.fn.App.newTab('list-stock');
                
        POS.app.getStore('Stock').search({
            product_id: productId
        });

        var notification = Ext.ComponentQuery.query('list-notification')[0];
        if (notification) notification.close();
    },
    
    remove: function(id){
        var panel = Ext.ComponentQuery.query('list-notification')[0];
        
        if (panel) panel.setLoading(true);
        var monitor = Ext.fn.WebSocket.monitor(
            Ext.ws.Main.on('notification/destroy', function(websocket, data){
                clearTimeout(monitor);
                panel.setLoading(false);
                if (data.success){
                    var store = POS.app.getStore('Notification');
                    
                    id.forEach(function(id){
                        store.remove(store.getById(id));
                    });
                }else{
                    Ext.fn.App.notification('Ups', data.errmsg);
                }
            }, this, {
                single: true,
                destroyable: true
            }),
            panel,
            false
        );
        Ext.ws.Main.send('notification/destroy', {id: id});
    },

    show: function(title, message, icon, manager){
        setTimeout(function(){
            Ext.create('widget.uxNotification', {
                title: '<i class="fa fa-' + (icon || 'exclamation-triangle') + ' glyph"></i> ' + title,
                autoCloseDelay: 5000,
                cls: 'ux-notification-light',
                hideDuration: 50,
                html: message,
                manager: (manager || Ext.getBody()),
                position: 'br',
                slideBackAnimation: 'bounceOut',
                slideBackDuration: 500,
                slideInAnimation: 'bounceOut',
                slideInDuration: 1000,
                maxWidth: 350
            }).show();
        }, 10);
    }
});