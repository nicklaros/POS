Ext.define('POS.tpl.DeveloperInfo', {
    extend: 'Ext.XTemplate',

    html: [
        '<img src="resources/images/dev-cover.jpg" style="width: 460px; height: 276px;">',
        '<table border="0" cellpadding="5" style="font-size:12px; font-weight:bold;">',
        '<tr>',
            '<td width="75">Email</td>',
            '<td>:</td>',
            '<td>{dev_email}</td>',
        '</tr>',
        '<tr>',
            '<td>Telp</td>',
            '<td>:</td>',
            '<td>{dev_phone}</td>',
        '</tr>',
        '<tr>',
            '<td>Website</td>',
            '<td>:</td>',
            '<td><a href="http://{dev_website}" target="blank">{dev_website}</a></td>',
        '</tr>',
        '<tr>',
            '<td>Alamat</td>',
            '<td>:</td>',
            '<td>{dev_address}</td>',
        '</tr>',
        '</table>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});