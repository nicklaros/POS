Ext.define('POS.model.Stock', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id',                type: 'int'},
        {name: 'product_id',        type: 'int'},
        {name: 'product_code',      type: 'string'},
        {name: 'product_name',      type: 'string'},
        {name: 'amount',            type: 'number'},
        {name: 'unit_id',           type: 'string'},
        {name: 'unit_name',         type: 'string'},
        {name: 'buy',               type: 'int'},
        {name: 'sell_public',       type: 'int'},
        {name: 'sell_distributor',  type: 'int'},
        {name: 'sell_misc',         type: 'int'},
        {name: 'discount',          type: 'number'},
        {name: 'unlimited',         type: 'int'}
    ]
});