Ext.define('POS.model.NotificationOption', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id',                type: 'int'},
        {name: 'role_id',           type: 'int'},
        {name: 'role_name',         type: 'string'}
    ]
});