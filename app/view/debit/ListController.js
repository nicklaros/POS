Ext.define('POS.view.debit.ListController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.list-debit',

    control: {
        '#': {
            selectionchange: function(sm, selected){
                var pay             = this.lookupReference('pay'),
                    purchaseDetail  = this.lookupReference('purchase_detail');

                pay.setDisabled(selected.length !== 1);
                purchaseDetail.setDisabled(selected.length !== 1);
            },
            celldblclick: 'pay',
            itemcontextmenu: 'showMenu'
        }
    },
    
    listPayment: function(){
        var panel = POS.fn.App.newTab('list-debit-payment');
        panel.getStore().search({});
    },
    
    pay: function(){
        var rec     = this.getView().getSelectionModel().getSelection()[0],
            params  = {
                debit_id: rec.get('id')
            };
        if (rec.get('balance') > 0) {
            var panel = POS.fn.App.window('pay-debit');
            panel.getController().load(params);
        } else {
            POS.fn.Notification.show('Lunas', 'Hutang ini sudah dilunasi.');
        }
    },

    purchaseDetail: function(){
        var rec     = this.getView().getSelectionModel().getSelection()[0],
            params  = {
                id: rec.get('purchase_id')
            };

        var detail = POS.fn.App.window('detail-purchase');
        detail.getController().load(params);
    },
    
    search: function(){
        POS.fn.App.window('search-debit');
    },
    
    showMenu: function(view, record, item, index, e, eOpts) {
        var me = this;
        
        e.stopEvent();
        if (!me.menu) {
            me.menu = new Ext.menu.Menu({
                plain: true,
                items : [{
                    text: '<i class="fa fa-money main-nav-icon"></i> Bayar',
                    handler: function(){
                        me.pay();
                    }
                },{
                    text: '<i class="fa fa-credit-card main-nav-icon"></i> Detail Pembelian',
                    handler: function(){
                        me.purchaseDetail();
                    }
                }]
            });
        }
        me.menu.showAt(e.getXY());
    },
    
    reset: function(){
        this.getView().getStore().search({});
    }
});
