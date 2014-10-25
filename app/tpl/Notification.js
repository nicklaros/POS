Ext.define('POS.tpl.Notification', {
    extend: 'Ext.XTemplate',

    html: [
        '<div class="notification-container">',
            '<div class="delete"><a onClick="POS.fn.Notification.remove([{id}])"><i class="fa fa-close"></i></a></div>',
            '<div class="body">',
                '<tpl switch="type">',
                    '<tpl case="price">',
                        'Harga {data.product_name} ',
                        '<tpl switch="data.status">',
                            '<tpl case="up">',
                                '<span class="red"> <i class="fa fa-caret-up"></i> naik </span>',
                            '<tpl case="down">',
                                '<span class="green"> <i class="fa fa-caret-down"></i> turun </span>',
                        '</tpl>',
                        'sebesar {[ POS.fn.Render.currency(values.data.difference) ]} menjadi {[ POS.fn.Render.currency(values.data.to_price) ]} per {data.unit_name}. ',
                        '<a onClick="POS.fn.Notification.checkProductPrice({data.product_id})">Cek harga</a>',
                    '<tpl default>',
                        'tipe pemberitahuan default.',
                '</tpl>',
                '<div class="time">{[ POS.fn.Render.time(values.time) ]}</div>',
            '</div>',
        '</div>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});