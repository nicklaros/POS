Ext.define('POS.custom.grid.SaledProduct', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grid-saled-product',
    
    requires: [
        'Ext.grid.column.RowNumberer'
    ],
    
    columnLines: true,
    selType: 'rowmodel',
    
    features: [{
        ftype: 'summary'
    }],
    
    minHeight: 200,
    
    initComponent: function(){
        this.columns = [
            Ext.create('Ext.grid.RowNumberer', {
                width: 50
            }),
            {header: 'Produk', dataIndex: 'product_name', width:310, sortable: true},
            {header: 'Terjual', dataIndex: 'saled_amount', width:85, sortable: true, align: 'right'},
            {header: 'Satuan', dataIndex: 'unit_name', width: 100, sortable: true,
                summaryRenderer: function(value) {
                    return '<strong>Total</strong>';
                }
            },
            {header: 'Total', dataIndex: 'saled_total', width: 150, sortable: true, renderer: POS.fn.Render.currency, align: 'right',
                summaryType: 'sum',
                summaryRenderer: function(value) {
                    return '<strong>' + POS.fn.Render.currency(value) + '</strong>';
                }
            }
        ];

        this.callParent(arguments);
    }
});