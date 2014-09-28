Ext.define('POS.view.customer.Detail', {
    extend: 'Ext.window.Window',
    alias : 'widget.customer-detail',
    id: 'customer-detail',
    controller: 'customer-detail',
    viewModel: {
        type: 'customer-detail'
    },

    requires: [
        'POS.custom.chart.transaction.MonthlyTransaction',
        'POS.custom.grid.SalesReport',
        'POS.custom.panel.CustomerStats',
        'POS.store.chart.transaction.customer.Last7Months',
        'POS.store.customer.MonthlySales',
        'POS.tpl.customer.Info',
        'POS.view.customer.DetailController',
        'POS.view.customer.DetailModel'
    ],

    layout: 'anchor',
    
	autoScroll: false,
    autoShow: false,
    bodyStyle: {
        'background-color': '#e9eaed',
        border: '0 !important'
    },
    cls: 'window',
    constrain: true,
    header: false,
    modal: true,
    resizable: false,
    
    padding: 0,
    width: 900,

    initComponent: function(){
        this.dockedItems = [{
            xtype: 'container',
            dock: 'top',
            layout: 'hbox',
            cls: 'panel-header window-header',
            style: {
                'border-bottom-width': '1px !important'
            },
            anchor: '100%',
			height: 85,
            items: [{
                xtype: 'container',
                tpl: Ext.create('POS.tpl.customer.Info'),
                bind: {
                    data: '{detail}'
                }
            },{
                xtype: 'container',
                flex: 1
            },{
                xtype: 'button',
                text: 'x',
                handler: 'close'
            }]
        }];
        
        this.items = [{
            xtype: 'tabpanel',
            activeTab: 0,
			bodyStyle: {
				border: '0 !important'
			},
            maxHeight: Ext.getBody().getViewSize().height - 85,
            items: [{
                xtype: 'panel',
                title: 'Statistik',
	            autoScroll: true,
                bodyStyle: {
                    'background-color': '#e9eaed',
                    border: '0 !important'
                },
                items: [{
                    xtype: 'container',
                    layout: 'vbox',
                    width: 850,
                    style: {
                        margin: '25px auto'
                    },
                    items: [{
                        xtype: 'container',
                        layout: 'hbox',
                        margin: '0 0 0 0',
                        width: '100%',
                        items: [{
                            xtype: 'customer-stats',
                            bind: {
                                data: '{stats}'
                            },
                            flex: 1
                        },{
                            xtype: 'container',
                            width: 20
                        },{
                            xtype: 'chart-monthly-transaction',
                            flex: 1
                        }]
                    }]
                }]
            },{
                xtype: 'grid-sales-report',
                title: 'Penjualan Bulan Ini',
                store: 'customer.MonthlySales'
            }]
        }];

        this.maxHeight = Ext.getBody().getViewSize().height;

        this.callParent(arguments);
    }
});