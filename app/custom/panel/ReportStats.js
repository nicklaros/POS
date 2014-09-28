Ext.define('POS.custom.panel.ReportStats', {
    extend: 'Ext.container.Container',
    alias: 'widget.report-stats',

    requires: [
        'POS.tpl.report.Stats'
    ],
    
    cls: 'panel',
    
    minHeight: 100,
    padding: 5,
    

    initComponent: function(){
        this.tpl = Ext.create('POS.tpl.report.Stats');
        
        this.callParent(arguments);
    }
});