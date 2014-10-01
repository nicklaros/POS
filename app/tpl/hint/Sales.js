Ext.define('POS.tpl.hint.Sales', {
    extend: 'Ext.XTemplate',

    html: [
        '<div class="hint-container white">',
            '<div class="block">[<strong>{sales_add_key}</strong>] Tambah Produk</div>',
            '<div class="block">[<strong>{sales_pay_key}</strong>] Masukkan Pembayaran</div>',
            '<div class="block">[<strong>{sales_save_key}</strong>] Simpan</div>',
            '<div class="block">[<strong>{sales_cancel_key}</strong>] Batal</div>',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});