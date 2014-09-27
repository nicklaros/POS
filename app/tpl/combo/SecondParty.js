Ext.define('POS.tpl.combo.SecondParty', {
    extend: 'Ext.XTemplate',

    html: [
        '<div class="lst">',
            '<strong>{name}</strong> <small>{type}</small>',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});