Ext.define('POS.store.Purchase', {
    extend: 'Ext.data.Store',
    model: 'POS.model.Purchase',

    remoteSort: true,
    pageSize: 100,

    sorters: [{
        property: 'date',
        direction: 'DESC'
    }],

    search: function(params){
        this.getProxy().extraParams = params;
        this.loadPage(1);
    }
});