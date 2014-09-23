Ext.define('POS.custom.grid.SalesDetail', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grid-sales-detail',

    requires: [
        'POS.store.SalesDetail'
    ],
    
    columnLines: true,
    selType: 'checkboxmodel',
    
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
            {header: 'Produk', dataIndex: 'product_name', width: 300},
            {header: 'Jumlah', dataIndex: 'amount', width: 90, align: 'right'},
            {header: 'Unit', dataIndex: 'unit_name', width: 90},
            {
                text: 'Harga',
                columns:[
                    {header: 'Satuan', dataIndex: 'unit_price', width: 125, renderer: Ext.fn.Render.currency, align: 'right'},
                    {header: 'Diskon', dataIndex: 'discount', width: 90, renderer: Ext.fn.Render.discount, align: 'right'},
                    {header: 'Total', dataIndex: 'total_price', width: 125, renderer: Ext.fn.Render.currency, align: 'right'}
                ]
            }
        );
        
        this.columns = columns;

        this.callParent(arguments);
    }
});