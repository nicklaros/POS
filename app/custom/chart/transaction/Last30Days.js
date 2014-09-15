Ext.define('POS.custom.chart.transaction.Last30Days', {
    extend: 'Ext.container.Container',
    alias: 'widget.chart-transaction-last30days',

    requires: [
        'Ext.fn.Render',
        'POS.store.chart.transaction.Last30Days'
    ],
    
    cls: 'panel',
    
    width: 800,
    

    initComponent: function(){
        this.items = [{
            xtype: 'container',
            html: 'Grafik Transaksi',
            cls: 'panel-header'
        },{
            xtype: 'chart',
            interactions: ['itemhighlight', 'iteminfo'],
            legend: {
                docked: 'right'
            },
            store: POS.app.getStore('POS.store.chart.transaction.Last30Days'),

            axes: [{
                type: 'numeric',
                position: 'left',
                fields: ['sales', 'purchase'],
                grid: true,
                minimum: 0,
                renderer: Ext.fn.Render.currency
            },{
                type: 'category',
                position: 'bottom',
                fields: 'date',
                renderer: Ext.util.Format.dateRenderer("d")
            }],

            series: [{
                type: 'line',
                axis: 'left',
                title: 'Penjualan',
                yField: 'sales',
                xField: 'date',
                smooth: true,
                style: {
                    lineWidth: 3
                },
                marker: {
                    radius: 2
                },
                highlight: {
                    fillStyle: '#000',
                    radius: 1,
                    lineWidth: 2,
                    strokeStyle: '#fff'
                },
                tooltip: {
                    trackMouse: true,
                    style: 'background: #fff',
                    renderer: function(storeItem, item) {
                        var title = item.series.getTitle();
                        this.setHtml(title + ' tanggal ' + Ext.fn.Render.date(storeItem.get('date'), true) + ': ' + Ext.fn.Render.currency(storeItem.get(item.series.getYField())));
                    }
                }
            },{
                type: 'line',
                axis: 'left',
                title: 'Pembelian',
                yField: 'purchase',
                xField: 'date',
                smooth: true,
                style: {
                    lineWidth: 3
                },
                marker: {
                    radius: 2
                },
                highlight: {
                    fillStyle: '#000',
                    radius: 1,
                    lineWidth: 2,
                    strokeStyle: '#fff'
                },
                tooltip: {
                    trackMouse: true,
                    style: 'background: #fff',
                    renderer: function(storeItem, item) {
                        var title = item.series.getTitle();
                        this.setHtml(title + ' tanggal ' + Ext.fn.Render.date(storeItem.get('date'), true) + ': ' + Ext.fn.Render.currency(storeItem.get(item.series.getYField())));
                    }
                }
            }],

            flex: 1,
            height: 250
        }];
        
        this.callParent(arguments);
    }
});