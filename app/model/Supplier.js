Ext.define('POS.model.Supplier', {
    extend: 'Ext.data.Model',

    fields: [
        {name: 'id',                type: 'int'},
        {name: 'name',              type: 'string'},
        {name: 'address',           type: 'string'},
        {name: 'phone',             type: 'string'}
    ]
});