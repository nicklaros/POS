Ext.define('POS.view.report.MonthlyController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.monthly-report',

    control: {
        '#': {
            boxready: function(){
                var store = POS.app.getStore('chart.transaction.MonthlySalesVsPurchase');
                this.getView().down('chart-sales-vs-purchase polar').setStore(store);
                
                var store = POS.app.getStore('chart.transaction.Monthly');
                this.getView().down('chart-transaction chart').setStore(store);
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
                Ext.fn.App.setLoading(false);
                panel.setLoading(false);
                if (result.success){
                    panel.show();
                    me.getViewModel().set('stats', result.data);
                }else{
                    panel.close();
                    Ext.fn.App.notification('Ups', result.errmsg);
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
        var month = this.lookupReference('month').getSubmitValue();
        
        this.process(month);
    }
    
});