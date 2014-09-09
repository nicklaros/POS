Ext.define('POS.store.combo.SellType', {
    extend: 'Ext.data.Store',
    fields: [
        {name: 'id', type: 'string'},
        {name: 'type', type: 'string'}
    ],

    data : [
        {id: 'Public', type: 'Biasa'},
        {id: 'Distributor', type: 'Grosir'},
        {id: 'Misc', type: 'Lain-lain'}
    ]
})