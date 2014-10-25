Ext.define('POS.view.purchase.DetailController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.detail-purchase',

    control: {
        '#': {
            close: function(){
                POS.app.getStore('PurchaseDetail').removeAll(true);
            }
        }
    },

    close: function(){
        this.getView().close();
    },

    load: function(params){
        var panel = this.getView();
        
        panel.purchase_id = params.id;

        POS.fn.App.setLoading(true);
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('purchase/viewDetail', function(websocket, result){
                clearTimeout(monitor);
                POS.fn.App.setLoading(false);
                if (result.success){
                    // update purchase detail template
                    this.lookupReference('detail-panel').update(result.data);

                    POS.app.getStore('PurchaseDetail').loadData(result.detail);

                    panel.show();
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
        Ext.ws.Main.send('purchase/viewDetail', params);
    }
    
});
