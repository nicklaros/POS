Ext.define('POS.custom.panel.hint.Dashboard', {
    extend: 'Ext.container.Container',
    alias: 'widget.dashboard-hint',

    requires: [
        'POS.tpl.hint.Dashboard'
    ],
    
    cls: 'panel',
    
    minHeight: 40,
    padding: 8,
    

    initComponent: function(){
        this.tpl = Ext.create('POS.tpl.hint.Dashboard');
        
        this.callParent(arguments);
    }
});