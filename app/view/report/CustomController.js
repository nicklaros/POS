Ext.define('POS.view.report.CustomController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.custom-report',

    control: {
        '#': {
            boxready: function(){
                var store = POS.app.getStore('POS.store.chart.transaction.CustomSalesVsPurchase');
                this.getView().down('chart-sales-vs-purchase polar').setStore(store);
            }
        }
    },

    close: function(){
        this.getView().close();
    },
    
    process: function(params){
        var me      = this,
            panel   = this.getView();
        
        panel.setLoading(true);
        var monitor = Ext.fn.WebSocket.monitor(
            Ext.ws.Main.on('report/custom', function(websocket, result){
                clearTimeout(monitor);
                Ext.fn.App.setLoading(false);
                panel.setLoading(false);
                if (result.success){
                    panel.show();
                    me.getViewModel().set('stats', result.data);
                }else{
                    panel.close();
                    me.getViewModel().set('stats', '');
                    Ext.fn.App.notification('Ups', result.errmsg);
                }
            }, this, {
                single: true,
                destroyable: true
            }),
            panel,
            false
        );
        Ext.ws.Main.send('report/custom', params);
    },
    
    viewReport: function(){
        var start   = this.lookupReference('start').getSubmitValue(),
            until   = this.lookupReference('until').getSubmitValue(),
            params  = {
                start: start,
                until: until
            };
        
        POS.app.getStore('POS.store.chart.transaction.CustomSalesVsPurchase').removeAll();
        POS.app.getStore('POS.store.report.CustomPurchasedProduct').removeAll();
        POS.app.getStore('POS.store.report.CustomSaledProduct').removeAll();
        
        this.process(params);
    }
    
});