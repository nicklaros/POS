Ext.define('POS.model.Barang', {
    extend: 'Ext.data.Model',

    fields: [
        {name: 'id', type: 'int'},
        {name: 'kode', type: 'string'},
        {name: 'nama', type: 'string'},
        {name: 'katagori', type: 'string'}
    ]
});