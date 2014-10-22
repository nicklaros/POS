Ext.define('POS.tpl.customer.Info', {
    extend: 'Ext.XTemplate',

    html: [
        '<div class="body-text">',
            '<strong style="font-size: 25px;">{name}</strong> Telp. <strong>{phone}</strong> <br />',
            'Terdaftar pada tanggal <strong>{[ Ext.util.Format.date(values.registered_date, "d F Y") ]}</strong> <br />',
            '<strong>{[ POS.fn.Render.gender(values.gender) ]}</strong> berusia <strong>{age}</strong> tahun beralamat di <strong>{address}</strong> <br />',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});