Ext.define('Ext.fn.WebSocket', {
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

    monitor: function(listener, panel){
        listener.panel = panel || '';
        Ext.defer(function(){
            if (this.observable.hasListener(this.args[0])){
                Ext.fn.App.setLoading(false);
                this.destroy();
                Ext.fn.App.notification('Ups', 'Gagal menghubungi server pemrosesan data...');
                if (panel = Ext.getCmp(this.panel.id)) panel.close();
            }
        }, 10000, listener);
    }
});