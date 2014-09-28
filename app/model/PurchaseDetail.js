Ext.define('POS.model.PurchaseDetail', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id',            type: 'int'},
        {name: 'purchase_id',   type: 'int'},
        {name: 'stock_id',      type: 'int'},
        {name: 'product_id',    type: 'int'},
        {name: 'product_name',  type: 'string'},
        {name: 'amount',        type: 'number'},
        {name: 'unit_name',     type: 'string'},
        {name: 'unit_price',    type: 'int'},
        {name: 'total_price',   type: 'int'}
    ]
});