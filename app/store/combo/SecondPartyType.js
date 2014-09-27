Ext.define('POS.store.combo.SecondPartyType', {
    extend: 'Ext.data.Store',
    fields: [
        {name: 'name', type: 'string'},
        {name: 'value', type: 'string'}
    ],

    data : [
        {name: 'Customer', value: 'Customer'},
        {name: 'Supplier', value: 'Supplier'}
    ]
})