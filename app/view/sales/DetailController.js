Ext.define('POS.view.sales.DetailController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.detail-sales',

    control: {
        '#': {
            close: function(){
                POS.app.getStore('SalesDetail').removeAll(true);
            }
        }
    },

    close: function(){
        this.getView().close();
    },

    load: function(params){
        var panel = this.getView();
        
        panel.sales_id = params.id;

        Ext.fn.App.setLoading(true);
        var monitor = Ext.fn.WebSocket.monitor(
            Ext.ws.Main.on('sales/viewDetail', function(websocket, result){
                clearTimeout(monitor);
                Ext.fn.App.setLoading(false);
                if (result.success){
                    // update sales detail template
                    this.lookupReference('detail-panel').update(result.data);

                    POS.app.getStore('SalesDetail').loadData(result.detail);

                    panel.show();
                }else{
                    panel.close();
                    Ext.fn.App.notification('Ups', result.errmsg);
                }
            }, this, {
                single: true,
                destroyable: true
            }),
            panel,
            true
        );
        Ext.ws.Main.send('sales/viewDetail', params);
    },

    print: function(){
        Ext.fn.App.printNotaSales(this.getView().sales_id);
    }
    
});
