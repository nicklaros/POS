Ext.define('POS.model.Sales', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id', type: 'int'},
        {name: 'date', type: 'date'},
        {name: 'customer_id', type: 'int'},
        {name: 'customer', type: 'string'},
        {name: 'buy_price', type: 'int'},
        {name: 'total_price', type: 'int'},
        {name: 'paid_price', type: 'int'},
        {name: 'cashier_id', type: 'int'},
        {name: 'cashier', type: 'string'},
        {name: 'note', type: 'string'},
        {name: 'status', type: 'string'}
    ]
});