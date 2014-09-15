Ext.define('POS.tpl.report.Stats', {
    extend: 'Ext.XTemplate',

    html: [
        '<div class="detail-block">',
            '<table>',
                '<tr>',
                    '<td>Penjualan sebanyak</td>',
                    '<td>:</td>',
                    '<td>{sales_count} kali</td>',
                '</tr>',
                '<tr>',
                    '<td>Penjualan sebesar</td>',
                    '<td>:</td>',
                    '<td>{[ Ext.fn.Render.currency(values.sales_total) ]}</td>',
                '</tr>',
                '<tr>',
                    '<td>Pembelian sebanyak</td>',
                    '<td>:</td>',
                    '<td>{purchase_count} kali</td>',
                '</tr>',
                '<tr>',
                    '<td>Pembelian sebesar</td>',
                    '<td>:</td>',
                    '<td>{[ Ext.fn.Render.currency(values.purchase_total) ]}</td>',
                '</tr>',
            '</table>',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});