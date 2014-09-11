Ext.define('POS.custom.grid.PurchaseDetail', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grid-purchase-detail',

    requires: [
        'POS.store.PurchaseDetail'
    ],
    
    columnLines: true,
    selType: 'checkboxmodel',
    
    minHeight: 150,
    
    columns: [
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
    ],

    initComponent: function(){
        this.store = POS.app.getStore('POS.store.PurchaseDetail');

        this.callParent(arguments);
    }
});