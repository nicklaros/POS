Ext.define('POS.custom.panel.hint.Sales', {
    extend: 'Ext.container.Container',
    alias: 'widget.sales-hint',

    requires: [
        'POS.tpl.hint.Sales'
    ],
    
    cls: 'panel',
    
    minHeight: 40,
    padding: 8,
    

    initComponent: function(){
        this.tpl = Ext.create('POS.tpl.hint.Sales');
        
        this.callParent(arguments);
    }
});