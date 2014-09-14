Ext.define('POS.model.Notification', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id',            type: 'int'},
        {name: 'time',          type: 'date'},
        {name: 'type',          type: 'string'},
        {name: 'status',        type: 'string'},
        {name: 'data',          type: 'auto'}
    ]
});