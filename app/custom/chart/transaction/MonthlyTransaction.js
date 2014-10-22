Ext.define('POS.custom.chart.transaction.MonthlyTransaction', {
    extend: 'Ext.container.Container',
    alias: 'widget.chart-monthly-transaction',

    requires: [
        'POS.fn.Render'
    ],
    
    cls: 'panel',

    initComponent: function(){
        this.items = [{
            xtype: 'container',
            html: 'Grafik Penjualan',
            cls: 'panel-header'
        },{
            xtype: 'chart',
            interactions: ['itemhighlight', 'iteminfo'],

            axes: [{
                type: 'numeric',
                position: 'left',
                fields: ['sales'],
                grid: true,
                minimum: 0,
                renderer: POS.fn.Render.plainCurrency
            },{
                type: 'category',
                position: 'bottom',
                fields: 'month',
                renderer: Ext.util.Format.dateRenderer("m")
            }],

            series: [{
                type: 'line',
                axis: 'left',
                title: 'Penjualan',
                yField: 'sales',
                xField: 'month',
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
                        this.setHtml(title + ' bulan ' + Ext.util.Format.date(storeItem.get('month'), "F") + ': ' + POS.fn.Render.currency(storeItem.get(item.series.getYField())));
                    }
                }
            }],

            flex: 1,
            height: 200
        }];
        
        this.callParent(arguments);
    }
});