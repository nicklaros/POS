Ext.define('POS.tpl.hint.Purchase', {
    extend: 'Ext.XTemplate',

    html: [
        '<div class="hint-container">',
            '<div class="block">[<strong>{purchase_add_key}</strong>] Tambah Produk</div>',
            '<div class="block">[<strong>{purchase_save_key}</strong>] Simpan</div>',
            '<div class="block">[<strong>{purchase_cancel_key}</strong>] Batal</div>',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});