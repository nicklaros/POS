Ext.define('POS.custom.grid.SalesDetail', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grid-sales-detail',

    requires: [
        'POS.store.SalesDetail'
    ],
    
    columnLines: true,
    selType: 'checkboxmodel',
    
    minHeight: 150,
    
    columns: [
        {header: 'Produk', dataIndex: 'product', width: 300},
        {header: 'Jumlah', dataIndex: 'amount', width: 90, align: 'right'},
        {header: 'Unit', dataIndex: 'unit', width: 90},
        {
            text: 'Harga',
            columns:[
                {header: 'Satuan', dataIndex: 'unit_price', width: 150, renderer: Ext.fn.Render.currency, align: 'right'},
                {header: 'Diskon', dataIndex: 'discount', width: 90, renderer: Ext.fn.Render.discount, align: 'right'},
                {header: 'Total', dataIndex: 'total_price', width: 150, renderer: Ext.fn.Render.currency, align: 'right'}
            ]
        }
    ],

    initComponent: function(){
        this.store = POS.app.getStore('POS.store.SalesDetail');

        this.callParent(arguments);
    }
});