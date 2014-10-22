Ext.define('POS.view.report.CustomController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.custom-report',

    control: {
        '#': {
            boxready: function(){
                var store = POS.app.getStore('chart.transaction.CustomSalesVsPurchase');
                this.getView().down('chart-sales-vs-purchase polar').setStore(store);
                
                var store = POS.app.getStore('chart.transaction.CustomDaily');
                this.getView().down('chart-transaction chart').setStore(store);
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
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('report/custom', function(websocket, result){
                clearTimeout(monitor);
                POS.fn.App.setLoading(false);
                panel.setLoading(false);
                if (result.success){
                    panel.show();
                    me.getViewModel().set('stats', result.data);
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
        Ext.ws.Main.send('report/custom', params);
    },
    
    viewReport: function(){
        var start   = this.lookupReference('start').getSubmitValue(),
            until   = this.lookupReference('until').getSubmitValue(),
            params  = {
                start: start,
                until: until
            };
        
        this.process(params);
    }
    
});