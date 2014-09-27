Ext.define('POS.model.Purchase', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id',                type: 'int'},
        {name: 'date',              type: 'date'},
        {name: 'second_party_id',   type: 'int'},
        {name: 'second_party_name', type: 'string'},
        {name: 'total_price',       type: 'int'},
        {name: 'paid',              type: 'int'},
        {name: 'balance',           type: 'int'},
        {name: 'note',              type: 'string'},
        {name: 'status',            type: 'string'}
    ]
});