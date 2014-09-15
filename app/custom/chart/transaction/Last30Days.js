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
            legend: {
                position: 'bottom'
            },
            store: POS.app.getStore('POS.store.chart.transaction.Last30Days'),

            axes: [{
                type: 'numeric',
                position: 'left',
                label: {
                    renderer: Ext.fn.Render.currency
                },
                grid: true,
                minimum: 0
            },{
                type: 'category',
                position: 'bottom',
                fields: ['date'],
                label: {
                    renderer: Ext.util.Format.dateRenderer("d")
                }
            }],

            series: [{
                type: 'line',
                axis: 'left',
                highlight: true,
                smooth: true,
                tips: {
                    trackMouse: true,
                    renderer: function(rec, item) {
                        this.setTitle('Penjualan');
                        this.update(Ext.fn.Render.date(rec.get('date'), true) + ' <br /> ' +
                            'Transaksi sebesar ' + Ext.fn.Render.currency(rec.get('sales')));
                    }
                },
                yField: 'sales',
                xField: 'date'
            },{
                type: 'line',
                axis: 'left',
                highlight: true,
                smooth: true,
                tips: {
                    trackMouse: true,
                    renderer: function(rec, item) {
                        this.setTitle('Pembelian');
                        this.update(Ext.fn.Render.date(rec.get('date'), true) + ' <br /> ' +
                            'Transaksi sebesar ' + renderCurrency(rec.get('purchase')));
                    }
                },
                xField: 'purchase',
                yField: 'date'
            }],

            flex: 1,
            height: 250
        }];
        
        this.callParent(arguments);
    }
});