Ext.define('POS.model.Purchase', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id',            type: 'int'},
        {name: 'date',          type: 'date'},
        {name: 'supplier_id',   type: 'int'},
        {name: 'supplier_name', type: 'string'},
        {name: 'total_price',   type: 'int'},
        {name: 'note',          type: 'string'},
        {name: 'status',        type: 'string'}
    ]
});