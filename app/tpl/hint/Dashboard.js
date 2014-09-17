Ext.define('POS.tpl.hint.Dashboard', {
    extend: 'Ext.XTemplate',

    html: [
        '<div class="hint-container">',
            '<div class="block">[<strong>{sales_key}</strong>] Penjualan Baru</div>',
            '<div class="block">[<strong>{purchase_key}</strong>] Pembelian Baru</div>',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});