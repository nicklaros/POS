Ext.define('POS.store.combo.LevelUser', {
    extend: 'Ext.data.Store',
    fields: [
        {name: 'val', type: 'string'}
    ],

    data : [
        {val: 'Admin'},
        {val: 'Pegawai'}
    ]
})