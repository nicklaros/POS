Ext.define('POS.store.Product', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Product',
    storeId: 'product',

    remoteSort: true,
    pageSize: 100,

    sorters: [{
        property: 'name',
        direction: 'ASC'
    }],

    search: function(params){
        this.getProxy().extraParams = params;
        this.loadPage(1);
    }
});