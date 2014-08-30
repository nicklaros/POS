Ext.define('Ext.tpl.combo.Produk', {
    extend: 'Ext.XTemplate',

    html: [
        '<div class="lst">',
        '<strong>{nama}</strong> {kode}',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});