Ext.define('POS.view.report.MonthlyController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.monthly-report',

    control: {
        '#': {
            boxready: function(){
                var store = POS.app.getStore('POS.store.chart.transaction.MonthlySalesVsPurchase');
                this.getView().down('chart-sales-vs-purchase polar').setStore(store);
                
                var store = POS.app.getStore('POS.store.chart.transaction.Monthly');
                this.getView().down('chart-transaction chart').setStore(store);
                
                this.viewReport();
            }
        }
    },

    close: function(){
        this.getView().close();
    },
    
    process: function(month){
        var me      = this,
            panel   = this.getView(),
            params  = {
                month: month
            };
        
        panel.setLoading(true);
        var monitor = Ext.fn.WebSocket.monitor(
            Ext.ws.Main.on('report/monthly', function(websocket, result){
                clearTimeout(monitor);
                panel.setLoading(false);
                if (result.success){
                    me.getViewModel().set('stats', result.data);
                }else{
                    me.getViewModel().set('stats', '');
                }
            }, this, {
                single: true,
                destroyable: true
            }),
            panel,
            false
        );
        Ext.ws.Main.send('report/monthly', params);
    },
    
    viewReport: function(){
        var month = this.lookupReference('month').getValue();
        
        POS.app.getStore('POS.store.chart.transaction.Monthly').removeAll();
        POS.app.getStore('POS.store.chart.transaction.MonthlySalesVsPurchase').removeAll();
        
        this.process(month);
    }
    
});