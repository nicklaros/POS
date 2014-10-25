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
                    '<td class="right">{[ POS.fn.Render.currency(values.sales_total) ]}</td>',
                    '<td>:</td>',
                    '<td class="center">Sebesar</td>',
                    '<td>:</td>',
                    '<td class="left">{[ POS.fn.Render.currency(values.purchase_total) ]}</td>',
                '</tr>',
            '</table>',
            '<br />',
            '<hr />',
            'Laba bersih penjualan sebesar {[ POS.fn.Render.currency(values.sales_netto) ]} <br />',
            'Piutang belum terbayar sebesar {[ POS.fn.Render.currency(values.credit) ]} <br />',
            'Hutang belum terbayar sebesar {[ POS.fn.Render.currency(values.debit) ]} <br />',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});