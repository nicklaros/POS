Ext.define('Ext.tpl.combo.Stock', {
    extend: 'Ext.XTemplate',

    html: [
        '<div class="lst">',
        '<strong>{name}</strong> <small>{code}</small> {unit}',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});