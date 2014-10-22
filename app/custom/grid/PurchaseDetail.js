Ext.define('POS.custom.grid.PurchaseDetail', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grid-purchase-detail',
    
    columnLines: true,
    selType: 'rowmodel',
    
    withRowNumber: false,
    
    minHeight: 150,
    
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
            {header: 'Produk', dataIndex: 'product_name', width: 300},
            {header: 'Jumlah', dataIndex: 'amount', width: 90, align: 'right'},
            {header: 'Unit', dataIndex: 'unit_name', width: 90},
            {header: 'Satuan', dataIndex: 'unit_price', width: 105, renderer: POS.fn.Render.currency, align: 'right'},
            {header: 'Total', dataIndex: 'total_price', width: 105, renderer: POS.fn.Render.currency, align: 'right'}
        );
        
        this.columns = columns;

        this.callParent(arguments);
    }
});