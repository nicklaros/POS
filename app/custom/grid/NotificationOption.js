Ext.define('POS.custom.grid.NotificationOption', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grid-notification-option',
    
    columnLines: true,
    hideHeaders: true,
    selType: 'rowmodel',
    
    withRowNumber: true,
    
    minHeight: 200,
    
    initComponent: function(){
        var columns = [];
        
        // check whether to add rownumberer or not
        if (this.withRowNumber == true) {
            var rowNumberer = {
                xtype: 'rownumberer',
                width: 50
            }
            
            columns.push(rowNumberer);
        }
        
        columns.push(
            {header: 'Jabatan', dataIndex: 'role_name', flex: 1}
        );
        
        this.columns = columns;

        this.callParent(arguments);
    }
});