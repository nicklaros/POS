Ext.define('POS.tpl.PurchaseDetail', {
    extend: 'Ext.XTemplate',

    html: [
        '<div class="detail-block">',
            '<table>',
                '<tr>',
                    '<td>Tanggal</td>',
                    '<td>:</td>',
                    '<td>{[ Ext.fn.Render.date(values.date, true) ]}</td>',
                '</tr>',
                '<tr>',
                    '<td>Supplier</td>',
                    '<td>:</td>',
                    '<td>{supplier_name}</td>',
                '</tr>',
                '<tr>',
                    '<td>Catatan</td>',
                    '<td>:</td>',
                    '<td>{note}</td>',
                '</tr>',
            '</table>',
        '</div>',
        '<div class="detail-block">',
            '<table>',
                '<tr>',
                    '<td>Harga Total</td>',
                    '<td>:</td>',
                    '<td class="right" style="width: 100px;">{[ Ext.fn.Render.currency(values.total_price) ]}</td>',
                '</tr>',
            '</table>',
        '</div>',
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});