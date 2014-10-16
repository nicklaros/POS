Ext.define('POS.store.purchase.EditDetail', {
    extend: 'Ext.data.Store',
    model: 'POS.model.PurchaseDetail',

    remoteSort: false,

    sorters: [{
        property: 'product_name',
        direction: 'ASC'
    }]
});