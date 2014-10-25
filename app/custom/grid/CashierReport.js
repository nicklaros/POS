Ext.define('POS.custom.grid.CashierReport', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grid-cashier-report',
    
    requires: [
        'POS.fn.Render'
    ],
    
    autoScroll: true,
    columnLines: true,
    selType: 'rowmodel',
    stripeRows: true,
    
    features: [{
        ftype: 'summary'
    }],
    
    minHeight: 200,

    initComponent: function() {
        this.columns = [
            Ext.create('Ext.grid.RowNumberer', {
                width: 50
            }),
            {header: 'Nama Kasir', dataIndex:'cashier_name', width: 300},
            {header: 'Banyak Penjualan', dataIndex: 'sales_amount', width: 150},
            {header: 'Besar Penjualan', dataIndex: 'sales_total', width: 150, renderer: POS.fn.Render.currency, align: 'right',
                summaryType: 'sum',
                summaryRenderer: function(value) {
                    return '<strong>' + POS.fn.Render.currency(value) + '</strong>';
                }
            }
        ];

        this.callParent(arguments);
    }
});