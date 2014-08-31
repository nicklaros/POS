Ext.define('POS.store.combo.Role', {
    extend: 'Ext.data.Store',
    fields: [
        {name: 'id', type: 'string'},
        {name: 'role', type: 'string'}
    ],

    data : [
        {id: 1, role: 'Super Admin'},
        {id: 2, role: 'Pegawai'}
    ]
})