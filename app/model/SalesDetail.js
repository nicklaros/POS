Ext.define('POS.model.SalesDetail', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id',                        type: 'int'},
        {name: 'sales_id',                  type: 'int'},
        {name: 'stock_id',                  type: 'int'},
        {name: 'product_name',              type: 'string'},
        {name: 'amount',                    type: 'number'},
        {name: 'discount',                  type: 'number'},
        {name: 'unit_id',                   type: 'int'},
        {name: 'unit_name',                 type: 'string'},
        {name: 'unit_price',                type: 'int'},
        {name: 'total_buy_price',           type: 'int'},
        {name: 'total_price_wo_discount',   type: 'int'},
        {name: 'total_price',               type: 'int'},
        {name: 'buy',                       type: 'int'},
        {name: 'sell_public',               type: 'int'},
        {name: 'sell_distributor',          type: 'int'},
        {name: 'sell_misc',                 type: 'int'}
    ]
});