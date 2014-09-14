Ext.define('POS.view.purchase.DetailController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.detail-purchase',

    control: {
        '#': {
            close: function(){
                POS.app.getStore('POS.store.PurchaseDetail').removeAll(true);
            }
        }
    },

    close: function(){
        this.getView().close();
    },

    load: function(params){
        var panel = this.getView();
        
        panel.purchase_id = params.id;

        Ext.fn.App.setLoading(true);
        var monitor = Ext.fn.WebSocket.monitor(
            Ext.ws.Main.on('purchase/viewDetail', function(websocket, result){
                clearTimeout(monitor);
                Ext.fn.App.setLoading(false);
                if (result.success){
                    // update purchase detail template
                    this.lookupReference('detail-panel').update(result.data);

                    POS.app.getStore('POS.store.PurchaseDetail').loadData(result.detail);

                    panel.show();
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
        Ext.ws.Main.send('purchase/viewDetail', params);
    }
    
});
