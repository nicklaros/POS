Ext.define('POS.fn.WebSocket', {
    singleton: true,

    create: function(url){
        return Ext.create('Ext.ux.WebSocket', {
            url: url,
            communicationType: 'event'
        });
    },

    listen: function(websocket){
        switch (websocket.getUrl().split('/').pop()){
            case 'Mains':
                websocket.on('open', function (ws) {
                    console.log('Main connection established.');
                });
                websocket.on('close', function (ws) {
                    console.log('Lost main connection.');
                });
                break;
            default :
                console.log('Passed WebSocket is unknown');
        }
    },

    register: function(websockets){
        websockets.forEach(function(websocket){
            Ext.ux.WebSocketManager.register(websocket);
        });
    },

    monitor: function(listener, panel, close){
        listener.panel = panel || '';
        listener.close = (Ext.isEmpty(close) ? true : close);
        return Ext.defer(function(){
            if (this.observable.hasListener(this.args[0])){
                POS.fn.App.setLoading(false);
                this.destroy();
                POS.fn.App.notification('Ups', 'Gagal menghubungi server pemrosesan data...');
                
                if (this.panel != '') {
                    var panel = Ext.getCmp(this.panel.id);
                    
                    if (!Ext.isEmpty(panel)) {
                        panel.setLoading(false);
                        if (this.close == true) panel.close();
                    }
                }
            }
        }, 10000, listener);
    }
});