Ext.define('POS.view.report.Custom' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.custom-report',
    id: 'custom-report',
    controller: 'custom-report',
    viewModel: {
        type: 'custom-report'
    },

    requires: [
        'POS.custom.chart.transaction.SalesVsPurchase',
        'POS.custom.field.Date',
        'POS.custom.grid.CashierReport',
        'POS.custom.grid.PurchasedProduct',
        'POS.custom.grid.PurchaseReport',
        'POS.custom.grid.SaledProduct',
        'POS.custom.grid.SalesReport',
        'POS.custom.panel.ReportStats',
        'POS.store.chart.transaction.CustomDaily',
        'POS.store.chart.transaction.CustomSalesVsPurchase',
        'POS.store.report.CustomPurchase',
        'POS.store.report.CustomPurchasedProduct',
        'POS.store.report.CustomSaledProduct',
        'POS.store.report.CustomSales',
        'POS.store.report.CustomSalesCashier',
        'POS.view.report.CustomController',
        'POS.view.report.CustomModel'
    ],

    layout: 'anchor',
    
	autoScroll: true,
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
                html: '<i class="fa fa-book glyph"></i> Laporan Tanggal',
                margin: '5 0 0 0'
            },{
                xtype: 'field-date',
                itemId: 'start',
                reference: 'start',
                allowBlank: false,
                msgTarget: 'side',
                value: new Date().addDays(-6),
                margin: '1 0 0 10',
                width: 130
            },{
                xtype: 'container',
                html: 'hingga',
                margin: '5 0 0 10'
            },{
                xtype: 'field-date',
                itemId: 'until',
                reference: 'until',
                allowBlank: false,
                msgTarget: 'side',
                value: new Date(),
                margin: '1 0 0 10',
                width: 130
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
                store: 'report.CustomSales'
            },{
                xtype: 'grid-saled-product',
                title: 'Produk yang Terjual',
                store: 'report.CustomSaledProduct'
            },{
                xtype: 'grid-purchase-report',
                title: 'Pembelian',
                store: 'report.CustomPurchase'
            },{
                xtype: 'grid-purchased-product',
                title: 'Produk yang Dibeli',
                store: 'report.CustomPurchasedProduct'
            },{
                xtype: 'grid-cashier-report',
                title: 'Kasir',
                store: 'report.CustomSalesCashier'
            }]
        }];

        this.maxHeight = Ext.getBody().getViewSize().height;

        this.callParent(arguments);
    }
});