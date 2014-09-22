Ext.define('POS.custom.grid.Notification', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grid-notification',

    requires: [
        'POS.store.Notification',
        'POS.tpl.Notification'
    ],
    
    columnLines: true,
    hideHeaders: true,
    selModel: {
        pruneRemoved: false
    },
    selType: 'rowmodel',
    viewConfig: {
        preserveScrollOnRefresh: true
    },
    
    minHeight: 150,
    
    initComponent: function(){
        this.store = POS.app.getStore('Notification');

        this.columns = [{
            xtype   : 'templatecolumn', 
            tpl     : Ext.create('POS.tpl.Notification'),
            flex    : 1
        }];

        this.callParent(arguments);
    }
});