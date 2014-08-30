Ext.define('POS.model.Stock', {
    extend: 'Ext.data.Model',
    fields: [
        {name: 'id', type: 'int'},
        {name: 'kode', type: 'string'},
        {name: 'nama', type: 'string'},
        {name: 'jumlah_stock', type: 'string'},
        {name: 'satuan', type: 'string'},
        {name: 'hrg_beli', type: 'int'},
        {name: 'hrg_jual_biasa', type: 'int'},
        {name: 'hrg_jual_grosir', type: 'int'},
        {name: 'hrg_jual_lain', type: 'int'},
        {name: 'diskon', type: 'int'}
    ]
});