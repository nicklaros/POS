Ext.define('POS.tpl.report.Stats', {
    extend: 'Ext.XTemplate',

    html: [
        '<div class="detail-block" style="width: 100%">',
            '<table width="100%">',
                '<tr>',
                    '<td class="auto right">Penjualan</td>',
                    '<td width="10"></td>',
                    '<td width="75"></td>',
                    '<td width="10"></td>',
                    '<td class="auto left">Pembelian</td>',
                '</tr>',
                '<tr>',
                    '<td class="right">{sales_count}</td>',
                    '<td>:</td>',
                    '<td class="center">Sebanyak</td>',
                    '<td>:</td>',
                    '<td class="left">{purchase_count}</td>',
                '</tr>',
                '<tr>',
                    '<td class="right">{[ Ext.fn.Render.currency(values.sales_total) ]}</td>',
                    '<td>:</td>',
                    '<td class="center">Sebesar</td>',
                    '<td>:</td>',
                    '<td class="left">{[ Ext.fn.Render.currency(values.purchase_total) ]}</td>',
                '</tr>',
            '</table>',
            '<br />',
            '<hr />',
            'Laba bersih penjualan sebesar {[ Ext.fn.Render.currency(values.sales_netto) ]}',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});