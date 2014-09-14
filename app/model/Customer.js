Ext.define('POS.model.Customer', {
    extend: 'Ext.data.Model',

    fields: [
        {name: 'id',                type: 'int'},
        {name: 'registered_date',   type: 'date'},
        {name: 'name',              type: 'string'},
        {name: 'address',           type: 'string'},
        {name: 'birthday',          type: 'date'},
        {name: 'gender',            type: 'string'},
        {name: 'phone',             type: 'string'}
    ]
});