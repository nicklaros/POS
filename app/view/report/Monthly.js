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
        'POS.custom.panel.MonthlyReportStats',
        'POS.view.report.MonthlyController',
        'POS.view.report.MonthlyModel'
    ],

    layout: 'anchor',
    
	autoScroll: true,
    autoShow: true,
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
                html: '<i class="fa fa-bell-o glyph"></i> Laporan Bulanan',
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
            items: ['Bulan: ',
            {
                xtype: 'monthfield', 
                reference: 'month', 
                editable: false,
                format: 'F Y',
                value: new Date(), 
                width: 150
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
                    xtype: 'monthly-report-stats',
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
        }];

        this.callParent(arguments);
    }
});