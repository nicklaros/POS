Ext.define('POS.store.SalesDetail', {
    extend: 'Ext.data.Store',
    model: 'POS.model.SalesDetail',
    storeId: 'sales-detail',

    remoteSort: true,
    pageSize: 100,

    sorters: [{
        property: 'id',
        direction: 'ASC'
    }],

    search: function(params){
        this.getProxy().extraParams = params;
        this.loadPage(1);
    }
});