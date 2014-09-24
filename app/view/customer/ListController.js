Ext.define('POS.view.customer.ListController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.list-customer',

    requires: [
        'Ext.fn.Util'
    ],

    control: {
        '#': {
            selectionchange: function(sm, selected){
                var btnDetail = this.lookupReference('detail'),
                    btnEdit = this.lookupReference('edit'),
                    btnDelete = this.lookupReference('delete');

                btnDetail.setDisabled(selected.length !== 1);
                btnEdit.setDisabled(selected.length !== 1);
                btnDelete.setDisabled(selected.length === 0);
            },
            celldblclick: 'detail',
            close: 'onClose',
            itemcontextmenu: 'showMenu'
        }
    },
    
    add: function(){
        Ext.fn.App.window('add-customer');
    },
    
    detail: function(){
        var rec     = this.getView().getSelectionModel().getSelection()[0],
            params  = {
                customer_id: rec.get('id')
            };

        var detail = Ext.fn.App.window('customer-detail');
        detail.getController().load(params);
    },

    edit: function(){
        var rec = this.getView().getSelectionModel().getSelection()[0];

        var edit = Ext.fn.App.window('edit-customer');
        edit.getController().load(rec.get('id'));
    },
    
    onClose: function(){
        Ext.destroy(this.menu);
    },
    
    remove: function(){
        var sm  = this.getView().getSelectionModel(),
            sel = sm.getSelection(),
            smCount = sm.getCount();
        Ext.Msg.confirm(
            '<i class="fa fa-exclamation-triangle glyph"></i> Hapus Data',
            '<b>Apakah Anda yakin akan menghapus data (<span style="color:red">' + smCount + ' data</span>)?</b><br>',
            function(btn){
                if (btn == 'yes'){
                    var id = [];
                    for(i=0;i<smCount;i++){
                        id.push(sel[i].get('id'));
                    }
                    var params = {
                        id: id
                    }

                    Ext.fn.App.setLoading(true);
                    var monitor = Ext.fn.WebSocket.monitor(
                        Ext.ws.Main.on('customer/destroy', function(websocket, result){
                            clearTimeout(monitor);
                            Ext.fn.App.setLoading(false);
                            if (result.success){
                                POS.app.getStore('Customer').load();
                            }else{
                                Ext.fn.App.notification('Ups', result.errmsg);
                            }
                        }, this, {
                            single: true,
                            destroyable: true
                        })
                    );
                    Ext.ws.Main.send('customer/destroy', params);
                }
            }
        );
    },
    
    reset: function(){
        this.getView().getStore().search({});
    },
    
    search: function(){
        Ext.fn.App.window('search-customer');
    },
    
    showMenu: function(view, record, item, index, e, eOpts) {
        var me = this;
        
        e.stopEvent();
        if (!me.menu) {
            me.menu = new Ext.menu.Menu({
                plain: true,
                items : [{
                    text: '<i class="fa fa-credit-card main-nav-icon"></i> Detail Pelanggan',
                    handler: function(){
                        me.detail();
                    }
                },{
                    text: '<i class="fa fa-shopping-cart main-nav-icon"></i> Data Transaksi Penjualan',
                    handler: function(){
                        me.showSales();
                    }
                },{
                    text: '<i class="fa fa-edit main-nav-icon"></i> Ubah Data Pelanggan',
                    handler: function(){
                        me.edit();
                    }
                },{
                    text: '<i class="fa fa-trash-o main-nav-icon"></i> Hapus Pelanggan',
                    handler: function(){
                        me.remove();
                    }
                }]
            });
        }
        me.menu.showAt(e.getXY());
    },
    
    showSales: function(){
        var rec = this.getView().getSelectionModel().getSelection()[0];

        Ext.fn.App.showCustomerSales(rec.get('id'))
    }
    
});
