Ext.define('POS.custom.panel.MonthlyReportStats', {
    extend: 'Ext.container.Container',
    alias: 'widget.monthly-report-stats',

    requires: [
        'POS.tpl.report.MonthlyStats'
    ],
    
    cls: 'panel',
    
    minHeight: 100,
    padding: 5,
    

    initComponent: function(){
        this.tpl = Ext.create('POS.tpl.report.MonthlyStats');
        
        this.callParent(arguments);
    }
});