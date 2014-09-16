Ext.define('POS.model.Credit', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id',            type: 'int'},
        {name: 'sales_id',      type: 'int'},
        {name: 'date',          type: 'date'},
        {name: 'customer_id',   type: 'int'},
        {name: 'customer_name', type: 'string'},
        {name: 'total',         type: 'int'},
        {name: 'paid',          type: 'int'},
        {name: 'balance',       type: 'int'},
        {name: 'cash_back',     type: 'int'}
    ]
});