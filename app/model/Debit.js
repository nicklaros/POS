Ext.define('POS.model.Debit', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id',            type: 'int'},
        {name: 'purchase_id',   type: 'int'},
        {name: 'date',          type: 'date'},
        {name: 'supplier_id',   type: 'int'},
        {name: 'supplier_name', type: 'string'},
        {name: 'total',         type: 'int'},
        {name: 'paid',          type: 'int'},
        {name: 'balance',       type: 'int'},
        {name: 'cash_back',     type: 'int'}
    ]
});