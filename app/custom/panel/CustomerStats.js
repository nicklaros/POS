Ext.define('POS.custom.panel.CustomerStats', {
    extend: 'Ext.container.Container',
    alias: 'widget.customer-stats',

    requires: [
        'POS.tpl.customer.Stats'
    ],
    
    cls: 'panel',
    
    minHeight: 100,
    padding: 10,
    

    initComponent: function(){
        this.tpl = Ext.create('POS.tpl.customer.Stats');
        
        this.callParent(arguments);
    }
});