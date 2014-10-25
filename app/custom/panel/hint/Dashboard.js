Ext.define('POS.custom.panel.hint.Dashboard', {
    extend: 'Ext.container.Container',
    alias: 'widget.dashboard-hint',

    requires: [
        'POS.tpl.hint.Dashboard'
    ],
    
    cls: 'panel hint-container',
    
    style: {
        'background-color': '#FF4141'
    },
    minHeight: 40,
    padding: 8,
    

    initComponent: function(){
        this.tpl = Ext.create('POS.tpl.hint.Dashboard');
        
        this.callParent(arguments);
    }
});