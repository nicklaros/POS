Ext.define('POS.model.SalesDetail', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id', type: 'int'},
        {name: 'sales_id', type: 'int'},
        {name: 'stock_id', type: 'int'},
        {name: 'product', type: 'string'},
        {name: 'amount', type: 'int'},
        {name: 'unit_id', type: 'int'},
        {name: 'unit', type: 'string'},
        {name: 'unit_price', type: 'int'},
        {name: 'discount', type: 'int'},
        {name: 'total_price_wo_discount', type: 'int'},
        {name: 'total_price', type: 'int'},
        {name: 'stock_buy', type: 'int'},
        {name: 'stock_sell_public', type: 'int'},
        {name: 'stock_sell_distributor', type: 'int'},
        {name: 'stock_sell_misc', type: 'int'},
        {name: 'stock_discount', type: 'int'},
        {name: 'status', type: 'string'}
    ]
});