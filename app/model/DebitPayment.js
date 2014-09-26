Ext.define('POS.model.DebitPayment', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id',            type: 'int'},
        {name: 'date',          type: 'date'},
        {name: 'debit_id',      type: 'int'},
        {name: 'supplier_id',   type: 'int'},
        {name: 'supplier_name', type: 'string'},
        {name: 'paid',          type: 'int'},
        {name: 'cashier_id',    type: 'int'},
        {name: 'cashier_name',  type: 'string'}
    ]
});