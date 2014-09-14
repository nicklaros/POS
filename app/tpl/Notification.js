Ext.define('POS.tpl.Notification', {
    extend: 'Ext.XTemplate',

    html: [
        '<div style="width: 570px;">',
        '<div class="notification-delete"><a onClick="Ext.fn.App.removeNotification([{id}])"><i class="fa fa-close"></i></a></div>',
        '<div class="notification-block">',
        '<tpl switch="type">',
            '<tpl case="price">',
                'Harga {data.product_name} {data.unit_name} ',
                '<tpl switch="data.status">',
                    '<tpl case="up">',
                        '<span class="red"> <i class="fa fa-caret-up"></i> naik </span>',
                    '<tpl case="down">',
                        '<span class="green"> <i class="fa fa-caret-down"></i> turun </span>',
                '</tpl>',
                ' sebesar {[ Ext.fn.Render.currency(values.data.difference) ]} menjadi {[ Ext.fn.Render.currency(values.data.to_price) ]} per {data.unit_name}. <br />',
                'Klik untuk cek harga stock.',
            '<tpl default>',
                'tipe pemberitahuan default',
        '</tpl>',
        '</div>',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});