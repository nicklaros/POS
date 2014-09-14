Ext.define('POS.custom.grid.Notification', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grid-notification',

    requires: [
        'POS.store.Notification',
        'POS.tpl.Notification'
    ],
    
    columnLines: true,
    hideHeaders: true,
    selType: 'rowmodel',
    
    minHeight: 150,
    
    initComponent: function(){
        this.store = POS.app.getStore('POS.store.Notification');

        this.columns = [{
            xtype   : 'templatecolumn', 
            tpl     : Ext.create('POS.tpl.Notification'),
            flex    : 1
        }];

        this.callParent(arguments);
    }
});