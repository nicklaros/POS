Ext.define('POS.view.customer.DetailController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.customer-detail',

    control: {
        '#': {
            boxready: function(){
                var store = POS.app.getStore('chart.transaction.customer.Last7Months');
                this.getView().down('chart-monthly-transaction chart').setStore(store);
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
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('report/monthly', function(websocket, result){
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
        Ext.ws.Main.send('report/monthly', params);
    },

    load: function(params){
        var me      = this,
            panel   = me.getView();
        
        panel.customer_id = params.customer_id;

        POS.fn.App.setLoading(true);
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('customer/viewDetail', function(websocket, result){
                clearTimeout(monitor);
                POS.fn.App.setLoading(false);
                if (result.success){
                    panel.show();
                    
                    // update info saved on view model
                    me.getViewModel().set('detail', result.detail);
                    
                    // update stats saved on view model
                    me.getViewModel().set('stats', result.stats);

                    POS.app.getStore('customer.MonthlySales').search(params);
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
        Ext.ws.Main.send('customer/viewDetail', params);
    }
    
});