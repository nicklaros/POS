Ext.define('POS.model.combo.Stock', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'stock_id',          type: 'int'},
        {name: 'product_code',      type: 'string'},
        {name: 'product_name',      type: 'string'},
        {name: 'unit_id',           type: 'string'},
        {name: 'unit_name',         type: 'string'},
        {name: 'buy',               type: 'int'},
        {name: 'sell_public',       type: 'int'},
        {name: 'sell_distributor',  type: 'int'},
        {name: 'sell_misc',         type: 'int'},
        {name: 'discount',          type: 'number'}
    ]
});