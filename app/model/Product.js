Ext.define('POS.model.Product', {
    extend: 'Ext.data.Model',

    fields: [
        {name: 'id',    type: 'int'},
        {name: 'code',  type: 'string'},
        {name: 'name',  type: 'string'}
    ]
});