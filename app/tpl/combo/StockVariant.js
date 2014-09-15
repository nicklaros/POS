Ext.define('POS.tpl.combo.StockVariant', {
    extend: 'Ext.XTemplate',

    html: [
        '<div class="lst">',
            '<strong>{unit_name}</strong> <small>{product_name}</small>',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});