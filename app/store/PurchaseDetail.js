Ext.define('POS.store.PurchaseDetail', {
    extend: 'Ext.data.Store',
    model: 'POS.model.PurchaseDetail',

    remoteSort: false,

    sorters: [{
        property: 'product_name',
        direction: 'ASC'
    }]
});