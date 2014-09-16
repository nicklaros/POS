Ext.define('POS.model.CreditPayment', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id',            type: 'int'},
        {name: 'date',          type: 'date'},
        {name: 'credit_id',     type: 'int'},
        {name: 'customer_id',   type: 'int'},
        {name: 'customer_name', type: 'string'},
        {name: 'paid',          type: 'int'},
        {name: 'cashier_id',    type: 'int'},
        {name: 'cashier_name',  type: 'string'}
    ]
});