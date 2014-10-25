Ext.define('POS.custom.grid.SalesDetail', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grid-sales-detail',
    
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
            {header: 'Produk', dataIndex: 'product_name', width: 290},
            {header: 'Jumlah', dataIndex: 'amount', width: 80, align: 'right'},
            {header: 'Unit', dataIndex: 'unit_name', width: 80},
            {header: 'Satuan', dataIndex: 'unit_price', width: 105, renderer: POS.fn.Render.currency, align: 'right'},
            {header: 'Diskon', dataIndex: 'discount', width: 90, renderer: POS.fn.Render.discount, align: 'right'},
            {header: 'Total', dataIndex: 'total_price', width: 105, renderer: POS.fn.Render.currency, align: 'right'},
            {header: 'Tipe', dataIndex: 'type', width: 90, renderer: POS.fn.Render.sellType}
        );
        
        this.columns = columns;

        this.callParent(arguments);
    }
});