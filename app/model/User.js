Ext.define('POS.model.User', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id',        type: 'int'},
        {name: 'user',      type: 'string'},
        {name: 'role_id',   type: 'int'},
        {name: 'role',      type: 'string'},
        {name: 'name',      type: 'string'},
        {name: 'address',   type: 'string'},
        {name: 'phone',     type: 'string'}
    ]
});