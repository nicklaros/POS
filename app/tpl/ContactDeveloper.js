Ext.define('POS.tpl.ContactDeveloper', {
    extend: 'Ext.XTemplate',

    html: [
        '<table>',
            '<tr>',
                '<td colspan="3" style="font-weight: bold; font-size: 14px; color: #868686;">{client_name}</td>',
            '</tr>',
            '<tr>',
                '<td width="100">Alamat</td>',
                '<td>:</td>',
                '<td>{client_address}</td>',
            '</tr>',
            '<tr>',
                '<td>Nomor Telp</td>',
                '<td>:</td>',
                '<td>{client_phone}</td>',
            '</tr>',
            '<tr>',
                '<td>Email</td>',
                '<td>:</td>',
                '<td>{client_email}</td>',
            '</tr>',
            '<tr>',
                '<td>Website</td>',
                '<td>:</td>',
                '<td>{client_website}</td>',
            '</tr>',
        '</table>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});