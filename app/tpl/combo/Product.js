Ext.define('POS.tpl.combo.Product', {
    extend: 'Ext.XTemplate',

    html: [
        '<div class="lst">',
            '<strong>{name}</strong> <small>{code}</small>',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});