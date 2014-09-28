Ext.define('POS.custom.panel.hint.Purchase', {
    extend: 'Ext.container.Container',
    alias: 'widget.purchase-hint',

    requires: [
        'POS.tpl.hint.Purchase'
    ],
    
    cls: 'panel',
    
    minHeight: 40,
    padding: 8,
    

    initComponent: function(){
        this.tpl = Ext.create('POS.tpl.hint.Purchase');
        
        this.callParent(arguments);
    }
});