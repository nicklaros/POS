Ext.define('POS.custom.grid.SalesDetail', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grid-sales-detail',

    requires: [
        'POS.store.SalesDetail'
    ],
    
    columnLines: true,
    selType: 'rowmodel',
    
    withRowNumber: false,
    
    minHeight: 150,
    
    initComponent: function(){
        this.store = POS.app.getStore('SalesDetail');
        
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
            {header: 'Satuan', dataIndex: 'unit_price', width: 105, renderer: Ext.fn.Render.currency, align: 'right'},
            {header: 'Diskon', dataIndex: 'discount', width: 90, renderer: Ext.fn.Render.discount, align: 'right'},
            {header: 'Total', dataIndex: 'total_price', width: 105, renderer: Ext.fn.Render.currency, align: 'right'},
            {header: 'Tipe', dataIndex: 'type', width: 90, renderer: Ext.fn.Render.sellType}
        );
        
        this.columns = columns;

        this.callParent(arguments);
    }
});