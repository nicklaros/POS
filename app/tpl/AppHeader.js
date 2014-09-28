Ext.define('POS.tpl.AppHeader', {
    extend: 'Ext.XTemplate',

    html: [
        '<div class="app-header">',
        '<img src="resources/images/logo.png" class="home-logo">',
        '{app_name}<br />',
        '<span style="font-size: 15px;">{client_name} {client_address} {client_phone}</span>',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});