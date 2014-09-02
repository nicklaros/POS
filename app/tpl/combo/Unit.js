Ext.define('Ext.tpl.combo.Unit', {
    extend: 'Ext.XTemplate',

    html: [
        '<div class="lst">',
        '<strong>{name}</strong>',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});