Ext.define('POS.store.Stock', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Stock',
    storeId: 'stock',

    remoteSort: true,
    pageSize: 100,

    sorters: [{
        property: 'nama',
        direction: 'ASC'
    }],

    search: function(params){
        this.getProxy().extraParams = params;
        this.loadPage(1);
    }
});