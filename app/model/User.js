Ext.define('POS.model.User', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id', type: 'int'},
        {name: 'user', type: 'string'},
        {name: 'level', type: 'string'},
        {name: 'nama', type: 'string'},
        {name: 'alamat', type: 'string'},
        {name: 'telp', type: 'string'}
    ]
});