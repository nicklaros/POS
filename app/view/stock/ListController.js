Ext.define('POS.view.stock.ListController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.list-stock',

    requires: [
        'POS.fn.Util'
    ],

    control: {
        '#': {
            boxready: function(panel){
                
            },
            selectionchange: function(sm, selected){
                var btnEdit = this.lookupReference('edit'),
                    btnDelete = this.lookupReference('delete');

                btnEdit.setDisabled(selected.length !== 1);
                btnDelete.setDisabled(selected.length === 0);
            },
            celldblclick: 'edit',
            itemcontextmenu: 'showMenu'
        }
    },
    
    add: function(){
        POS.fn.App.window('add-stock')
    },

    edit: function(){
        var rec = this.getView().getSelectionModel().getSelection()[0];

        var edit = POS.fn.App.window('edit-stock');
        edit.getController().load(rec.get('id'));
    },

    editProduct: function(){
        var rec = this.getView().getSelectionModel().getSelection()[0];

        var edit = POS.fn.App.window('edit-product');
        edit.getController().load(rec.get('product_id'));
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

                    POS.fn.App.setLoading(true);
                    var monitor = POS.fn.WebSocket.monitor(
                        Ext.ws.Main.on('stock/destroy', function(websocket, data){
                            clearTimeout(monitor);
                            POS.fn.App.setLoading(false);
                            if (data.success){
                                POS.app.getStore('Stock').load();
                            }else{
                                POS.fn.App.notification('Ups', data.errmsg);
                            }
                        }, this, {
                            single: true,
                            destroyable: true
                        })
                    );
                    Ext.ws.Main.send('stock/destroy', {id: id});
                }
            }
        );
    },
    
    search: function(){
        POS.fn.App.window('search-stock');
    },
    
    showMenu: function(view, record, item, index, e, eOpts) {
        var me = this;
        
        e.stopEvent();
        if (!me.menu) {
            me.menu = new Ext.menu.Menu({
                plain: true,
                items : [{
                    text: '<i class="fa fa-edit main-nav-icon"></i> Ubah Data Stock',
                    handler: function(){
                        me.edit();
                    }
                },{
                    text: '<i class="fa fa-edit main-nav-icon"></i> Ubah Kode atau Nama Produk',
                    handler: function(){
                        me.editProduct();
                    }
                },{
                    text: '<i class="fa fa-trash-o main-nav-icon"></i> Hapus Stock',
                    handler: function(){
                        me.remove();
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
