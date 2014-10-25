Ext.define('POS.store.purchase.AddDetail', {
    extend: 'Ext.data.Store',
    model: 'POS.model.PurchaseDetail',

    remoteSort: false,

    sorters: [{
        property: 'product_name',
        direction: 'ASC'
    }]
});