Ext.define('POS.custom.grid.SalesReport', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.grid-sales-report',
    
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
            {header: 'Nota', dataIndex:'id', width: 75},
            {header: 'Tanggal', dataIndex: 'date', width: 150, renderer: POS.fn.Render.date},
            {header: 'Dijual Ke', dataIndex: 'second_party_name', width: 200,
                summaryRenderer: function(value) {
                    return '<strong>Total</strong>';
                }
            },
            {header: 'Total', dataIndex: 'total_price', width: 125, renderer: POS.fn.Render.currency, align: 'right',
                summaryType: 'sum',
                summaryRenderer: function(value) {
                    return '<strong>' + POS.fn.Render.currency(value) + '</strong>';
                }
            },
            {header: 'Kasir', dataIndex: 'cashier_name', width: 120}
        ];

        this.callParent(arguments);
    }
});