Ext.define('POS.custom.grid.PurchaseDetail', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grid-purchase-detail',

    requires: [
        'POS.store.PurchaseDetail'
    ],
    
    columnLines: true,
    selType: 'checkboxmodel',
    
    withRowNumber: false,
    
    minHeight: 150,
    
    initComponent: function(){
        this.store = POS.app.getStore('POS.store.PurchaseDetail');
        
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
            {
                text: 'Harga',
                columns:[
                    {header: 'Satuan', dataIndex: 'unit_price', width: 150, renderer: Ext.fn.Render.currency, align: 'right'},
                    {header: 'Total', dataIndex: 'total_price', width: 150, renderer: Ext.fn.Render.currency, align: 'right'}
                ]
            }
        );
        
        this.columns = columns;

        this.callParent(arguments);
    }
});