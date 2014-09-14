Ext.define('POS.tpl.combo.Stock', {
    extend: 'Ext.XTemplate',

    html: [
        '<div class="lst">',
            '<strong>{product_name}</strong> <small>{product_code}</small> {unit_name}',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});