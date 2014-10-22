Ext.define('POS.custom.chart.transaction.SalesVsPurchase', {
    extend: 'Ext.container.Container',
    alias: 'widget.chart-sales-vs-purchase',

    requires: [
        'POS.fn.Render',
        'Ext.chart.PolarChart'
    ],
    
    cls: 'panel',
    

    initComponent: function(){
        this.items = [{
            xtype: 'container',
            html: 'Penjualan vs Pembelian',
            cls: 'panel-header'
        },{
            xtype: 'polar',
            insetPadding: 20,
            innerPadding: 10,
            interactions: ['itemhighlight'],
            legend: {
                docked: 'right'
            },

            series: [{
                type: 'pie',
                angleField: 'amount',
                label: {
                    field: 'type',
                    calloutLine: {
                        length: 30,
                        width: 3
                        // specifying 'color' is also possible here
                    }
                },
                highlight: true,
                tooltip: {
                    trackMouse: true,
                    renderer: function(storeItem, item) {
                        this.setHtml(storeItem.get('type') + ': ' + POS.fn.Render.currency(storeItem.get('amount')));
                    }
                }
            }],

            flex: 1,
            height: 170
        }];
        
        this.callParent(arguments);
    }
});