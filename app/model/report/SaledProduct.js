Ext.define('POS.model.report.SaledProduct', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'stock_id',                  type: 'int'},
        {name: 'product_name',              type: 'string'},
        {name: 'unit_name',                 type: 'string'},
        {name: 'saled_amount',              type: 'int'},
        {name: 'saled_total',               type: 'int'}
    ]
});