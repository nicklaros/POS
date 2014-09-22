Ext.define('POS.tpl.AppPhoto', {
    extend: 'Ext.XTemplate',

    html: [
        '<img src="resources/images/{app_photo}" style="width: 562px; height: 241px; border-radius: 2px;" />'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});