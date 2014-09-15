Ext.define('POS.model.report.PurchasedProduct', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'stock_id',                  type: 'int'},
        {name: 'product_name',              type: 'string'},
        {name: 'unit_name',                 type: 'string'},
        {name: 'purchased_amount',          type: 'int'},
        {name: 'purchased_total',           type: 'int'}
    ]
});