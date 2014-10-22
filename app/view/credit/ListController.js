Ext.define('POS.view.credit.ListController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.list-credit',

    control: {
        '#': {
            selectionchange: function(sm, selected){
                var pay         = this.lookupReference('pay'),
                    print       = this.lookupReference('print'),
                    salesDetail = this.lookupReference('sales_detail');

                pay.setDisabled(selected.length !== 1);
                print.setDisabled(selected.length !== 1);
                salesDetail.setDisabled(selected.length !== 1);
            },
            celldblclick: 'pay',
            itemcontextmenu: 'showMenu'
        }
    },
    
    listPayment: function(){
        var panel = POS.fn.App.newTab('list-credit-payment');
        panel.getStore().search({});
    },
    
    pay: function(){
        var rec     = this.getView().getSelectionModel().getSelection()[0],
            params  = {
                credit_id: rec.get('id')
            };
        
        if (rec.get('balance') > 0) {
            var panel = POS.fn.App.window('pay-credit');
            panel.getController().load(params);
        } else {
            POS.fn.Notification.show('Lunas', 'Piutang ini sudah dilunasi.');
        }
    },
    
    print: function(){
        var rec  = this.getView().getSelectionModel().getSelection()[0];

        POS.fn.App.printNotaCredit(rec.get('id'));
    },

    salesDetail: function(){
        var rec     = this.getView().getSelectionModel().getSelection()[0],
            params  = {
                id: rec.get('sales_id')
            };

        var detail = POS.fn.App.window('detail-sales');
        detail.getController().load(params);
    },
    
    search: function(){
        POS.fn.App.window('search-credit');
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
                    text: '<i class="fa fa-credit-card main-nav-icon"></i> Detail Penjualan',
                    handler: function(){
                        me.salesDetail();
                    }
                },{
                    text: '<i class="fa fa-print main-nav-icon"></i> Print',
                    handler: function(){
                        me.print();
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
