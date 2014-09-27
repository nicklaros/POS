Ext.define('POS.model.Sales', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id',                type: 'int'},
        {name: 'date',              type: 'date'},
        {name: 'second_party_id',   type: 'int'},
        {name: 'second_party_name', type: 'string'},
        {name: 'buy_price',         type: 'int'},
        {name: 'total_price',       type: 'int'},
        {name: 'paid',              type: 'int'},
        {name: 'balance',           type: 'int'},
        {name: 'cashier_id',        type: 'int'},
        {name: 'cashier_name',      type: 'string'},
        {name: 'note',              type: 'string'},
        {name: 'status',            type: 'string'}
    ]
});