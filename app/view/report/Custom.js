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
        'POS.custom.grid.PurchasedProduct',
        'POS.custom.grid.SaledProduct',
        'POS.custom.panel.ReportStats',
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
                html: '<i class="fa fa-book glyph"></i> Laporan Dalam Rentang Waktu',
                flex: 1
            },{
                xtype: 'buttonsegment',
                items: [{
                    text: 'x',
                    handler: 'close'
                }]
            }]
        },{
            xtype: 'toolbar',
            dock: 'top',
            style: {
                'background': '#7B8E9B'
            },
            items: [{
                xtype: 'container',
                html: 'Mulai tanggal',
                style: {
                    color: '#fff',
                    'font-weight': 'bold'
                },
                margin: '5 0 0 0'
            },{
                xtype: 'field-date',
                reference: 'start',
                allowBlank: false,
                msgTarget: 'side',
                value: new Date().addDays(-6),
                margin: '0 0 0 10',
                width: 130
            },{
                xtype: 'container',
                html: 'hingga',
                style: {
                    color: '#fff',
                    'font-weight': 'bold'
                },
                margin: '5 0 0 10'
            },{
                xtype: 'field-date',
                reference: 'until',
                allowBlank: false,
                msgTarget: 'side',
                value: new Date(),
                margin: '0 0 0 10',
                width: 130
            },{
                xtype: 'button',
                text:'<i class="fa fa-binoculars glyph"></i> Lihat laporan',
                margin: '0 0 0 10',
                handler: 'viewReport'
            }]
        }];
        
        this.items = [{
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
                xtype: 'container',
                cls: 'panel',
                margin: '0 0 25 0',
                width: '100%',
                items:[{
                    xtype: 'container',
                    html: 'Produk yang Terjual',
                    cls: 'panel-header'
                },{
                    xtype: 'grid-saled-product',
                    store: POS.app.getStore('POS.store.report.CustomSaledProduct'),
                    flex: 1
                }]
            },{
                xtype: 'container',
                cls: 'panel',
                margin: '0 0 0 0',
                width: '100%',
                items:[{
                    xtype: 'container',
                    html: 'Produk yang Dibeli',
                    cls: 'panel-header'
                },{
                    xtype: 'grid-purchased-product',
                    store: POS.app.getStore('POS.store.report.CustomPurchasedProduct'),
                    flex: 1
                }]
            }]
        }];

        this.maxHeight = Ext.getBody().getViewSize().height;

        this.callParent(arguments);
    }
});