Ext.define('POS.view.purchase.ListController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.list-purchase',

    control: {
        '#': {
            boxready: function(panel){
                var add = this.lookupReference('add');
                setTimeout(function(){
                    add.focus();
                }, 10);
            },
            selectionchange: function(sm, selected){
                var btnDetail = this.lookupReference('detail'),
                    btnEdit = this.lookupReference('edit'),
                    btnCancel = this.lookupReference('cancel');

                btnDetail.setDisabled(selected.length !== 1);
                btnEdit.setDisabled(selected.length !== 1);
                btnCancel.setDisabled(selected.length === 0);
            },
            celldblclick: 'detail',
            itemcontextmenu: 'showMenu'
        }
    },
    
    add: function(){
        var addPurchase = POS.fn.App.newTab('add-purchase');

        addPurchase.getController().add();
    },

    detail: function(){
        var rec     = this.getView().getSelectionModel().getSelection()[0],
            params  = {
                id: rec.get('id')
            };

        var detail = POS.fn.App.window('detail-purchase');
        detail.getController().load(params);
    },

    edit: function(){
        var rec     = this.getView().getSelectionModel().getSelection()[0],
            params  = {
                id: rec.get('id')
            };

        var edit = POS.fn.App.newTab('edit-purchase');
        edit.getController().load(params);
    },
    
    cancel: function(){
        var sm      = this.getView().getSelectionModel(),
            sel     = sm.getSelection(),
            smCount = sm.getCount();

        Ext.Msg.confirm(
            '<i class="fa fa-exclamation-triangle glyph"></i> Batalkan Pembelian ',
            '<p><b>Apakah Anda yakin akan membatalkan pembelian (<span style="color:red">' + smCount + ' data</span>)?</b>',
            function(btn){
                if (btn == 'yes'){
                    var id = [];
                    for(i=0;i<smCount;i++){
                        id.push(sel[i].get('id'));
                    }

                    POS.fn.App.setLoading(true);
                    var monitor = POS.fn.WebSocket.monitor(
                        Ext.ws.Main.on('purchase/cancel', function(websocket, data){
                            clearTimeout(monitor);
                            POS.fn.App.setLoading(false);
                            if (data.success){
                                POS.app.getStore('Purchase').load();
                            }else{
                                POS.fn.App.notification('Ups', data.errmsg);
                            }
                        }, this, {
                            single: true,
                            destroyable: true
                        })
                    );
                    Ext.ws.Main.send('purchase/cancel', {id: id});
                }
            }
        );
    },
    
    search: function(){
        POS.fn.App.window('search-purchase');
    },
    
    showMenu: function(view, record, item, index, e, eOpts) {
        var me = this;
        
        e.stopEvent();
        if (!me.menu) {
            me.menu = new Ext.menu.Menu({
                plain: true,
                items : [{
                    text: '<i class="fa fa-credit-card main-nav-icon"></i> Detail Pembelian',
                    handler: function(){
                        me.detail();
                    }
                },{
                    text: '<i class="fa fa-edit main-nav-icon"></i> Ubah Data Pembelian',
                    handler: function(){
                        me.edit();
                    }
                },{
                    text: '<i class="fa fa-undo main-nav-icon"></i> Batalkan Pembelian',
                    handler: function(){
                        me.cancel();
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
