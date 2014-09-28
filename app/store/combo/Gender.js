Ext.define('POS.store.combo.Gender', {
    extend: 'Ext.data.Store',
    fields: [
        {name: 'name', type: 'string'},
        {name: 'value', type: 'string'}
    ],

    data : [
        {name: 'Laki-laki', value: 'Male'},
        {name: 'Perempuan', value: 'Female'}
    ]
})