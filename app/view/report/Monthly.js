Ext.define('POS.view.report.Monthly' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.monthly-report',
    id: 'monthly-report',
    controller: 'monthly-report',
    viewModel: {
        type: 'monthly-report'
    },

    requires: [
        'Ext.ux.form.field.Month',
        'POS.custom.chart.transaction.SalesVsPurchase',
        'POS.custom.chart.transaction.Transaction',
        'POS.custom.grid.CashierReport',
        'POS.custom.grid.PurchasedProduct',
        'POS.custom.grid.PurchaseReport',
        'POS.custom.grid.SaledProduct',
        'POS.custom.grid.SalesReport',
        'POS.custom.panel.ReportStats',
        'POS.store.chart.transaction.Daily',
        'POS.store.chart.transaction.MonthlySalesVsPurchase',
        'POS.store.report.MonthlyPurchase',
        'POS.store.report.MonthlyPurchasedProduct',
        'POS.store.report.MonthlySaledProduct',
        'POS.store.report.MonthlySales',
        'POS.store.report.MonthlySalesCashier',
        'POS.view.report.MonthlyController',
        'POS.view.report.MonthlyModel'
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
            items: [{
                xtype: 'container',
                margin: '5 0 0 0',
                html: '<i class="fa fa-book glyph"></i> Laporan Bulan'
            },{
                xtype: 'monthfield', 
                reference: 'month', 
                editable: false,
                format: 'F Y',
                submitFormat: 'Y-m-d',
                value: new Date(), 
                margin: '0 0 0 10',
                width: 150
            },{
                xtype: 'button',
                text:'<i class="fa fa-binoculars glyph"></i> Lihat laporan',
                margin: '0 0 0 10',
                handler: 'viewReport'
            },{
                xtype: 'container',
                flex: 1
            },{
                xtype: 'buttonsegment',
                items: [{
                    text: 'x',
                    handler: 'close'
                }]
            }]
        }];
        
        this.items = [{
            xtype: 'tabpanel',
            activeTab: 0,
			bodyStyle: {
				border: '0 !important'
			},
            maxHeight: Ext.getBody().getViewSize().height - 52,
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
                        margin: '0 0 25 0',
                        width: '100%',
                        items: [{
                            xtype: 'report-stats',
                            bind: {
                                data: '{stats}'
                            },
                            flex: 1
                        },{
                            xtype: 'container',
                            width: 20
                        },{
                            xtype: 'chart-sales-vs-purchase',
                            flex: 1
                        }]
                    },{
                        xtype: 'chart-transaction',
                        width: 850
                    }]
                }]
            },{
                xtype: 'grid-sales-report',
                title: 'Penjualan',
                store: 'report.MonthlySales'
            },{
                xtype: 'grid-saled-product',
                title: 'Produk yang Terjual',
                store: 'report.MonthlySaledProduct'
            },{
                xtype: 'grid-purchase-report',
                title: 'Pembelian',
                store: 'report.MonthlyPurchase'
            },{
                xtype: 'grid-purchased-product',
                title: 'Produk yang Dibeli',
                store: 'report.MonthlyPurchasedProduct'
            },{
                xtype: 'grid-cashier-report',
                title: 'Kasir',
                store: 'report.MonthlySalesCashier'
            }]
        }];

        this.maxHeight = Ext.getBody().getViewSize().height;

        this.callParent(arguments);
    }
});