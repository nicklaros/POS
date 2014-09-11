Ext.define('POS.store.User', {
    extend: 'Ext.data.Store',
    model: 'POS.model.User',

    remoteSort: true,
    pageSize: 100,

    sorters: [{
        property: 'id',
        direction: 'DESC'
    }],

    search: function(params){
        this.getProxy().extraParams = params;
        this.loadPage(1);
    }
});