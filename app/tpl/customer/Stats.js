Ext.define('POS.tpl.customer.Stats', {
    extend: 'Ext.XTemplate',
    
    requires: [
        'Ext.fn.Customer'
    ],

    html: [
        '<div class="detail-block" style="width: 100%">',
            '<table width="100%">',
                '<tr>',
                    '<td class="right" width="150">Penjualan bulan ini</td>',
                    '<td width="10">:</td>',
                    '<td class="auto left">{sales_count_this_month} kali</td>',
                '</tr>',
                '<tr>',
                    '<td></td>',
                    '<td></td>',
                    '<td class="auto left">{[ Ext.fn.Render.currency(values.sales_total_this_month) ]}</td>',
                '</tr>',
                '<tr>',
                    '<td class="right">Penjualan tahun ini</td>',
                    '<td>:</td>',
                    '<td class="left">{sales_count_this_year} kali </td>',
                '</tr>',
                '<tr>',
                    '<td></td>',
                    '<td></td>',
                    '<td class="auto left">{[ Ext.fn.Render.currency(values.sales_total_this_year) ]}</td>',
                '</tr>',
                '<tr>',
                    '<td class="right">Piutang</td>',
                    '<td>:</td>',
                    '<td class="left"><a onClick="Ext.fn.Customer.showCredit({customer_id})">{[ Ext.fn.Render.currency(values.credit) ]} <i class="fa fa-external-link-square glyph"></i> </a></td>',
                '</tr>',
            '</table>',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});