Ext.define('POS.custom.chart.transaction.Transaction', {
    extend: 'Ext.container.Container',
    alias: 'widget.chart-transaction',

    requires: [
        'POS.fn.Render'
    ],
    
    cls: 'panel',

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

            axes: [{
                type: 'numeric',
                position: 'left',
                fields: ['sales', 'purchase'],
                grid: true,
                minimum: 0,
                renderer: POS.fn.Render.plainCurrency
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
                highlight: true,
                highlightCfg: {
                    fillStyle: '#000',
                    radius: 3,
                    lineWidth: 2,
                    strokeStyle: '#fff'
                },
                tooltip: {
                    trackMouse: true,
                    style: 'background: #fff',
                    renderer: function(storeItem, item) {
                        var title = item.series.getTitle();
                        this.setHtml(title + ' hari ' + POS.fn.Render.date(storeItem.get('date'), true) + ': ' + POS.fn.Render.currency(storeItem.get(item.series.getYField())));
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
                highlight: true,
                highlightCfg: {
                    fillStyle: '#000',
                    radius: 3,
                    lineWidth: 2,
                    strokeStyle: '#fff'
                },
                tooltip: {
                    trackMouse: true,
                    style: 'background: #fff',
                    renderer: function(storeItem, item) {
                        var title = item.series.getTitle();
                        this.setHtml(title + ' hari ' + POS.fn.Render.date(storeItem.get('date'), true) + ': ' + POS.fn.Render.currency(storeItem.get(item.series.getYField())));
                    }
                }
            }],

            flex: 1,
            height: 250
        }];
        
        this.callParent(arguments);
    }
});