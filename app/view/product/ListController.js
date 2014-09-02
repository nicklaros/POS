Ext.define('POS.view.product.ListController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.list-product',

    requires: [
        'Ext.fn.Util'
    ],

    control: {
        '#': {
            boxready: function(panel){
                this.getView().getStore().search({});
            },
            selectionchange: function(sm, selected){
                var btnEdit = this.lookupReference('edit'),
                    btnDelete = this.lookupReference('delete');

                btnEdit.setDisabled(selected.length !== 1);
                btnDelete.setDisabled(selected.length === 0);
            },
            celldblclick: function(){
                this.edit();
            }
        }
    },
    
    add: function(){
        Ext.fn.App.window('add-product');
    },
    
    delete: function(){
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

                    Ext.fn.App.setLoading(true);
                    Ext.ws.Main.send('product/destroy', {id: id});
                    var monitor = Ext.fn.WebSocket.monitor(
                        Ext.ws.Main.on('product/destroy', function(websocket, data){
                            clearTimeout(monitor);
                            Ext.fn.App.setLoading(false);
                            if (data.success){
                                POS.app.getStore('POS.store.Product').load();
                            }else{
                                Ext.fn.App.notification('Ups', data.errmsg);
                            }
                        }, this, {
                            single: true,
                            destroyable: true
                        })
                    );
                }
            }
        );
    },

    edit: function(){
        var rec = this.getView().getSelectionModel().getSelection()[0];

        var edit = Ext.fn.App.window('edit-product');
        edit.getController().load(rec.get('id'));
    },
    
    reset: function(){
        this.getView().getStore().search({});
    },
    
    search: function(){
        Ext.fn.App.window('search-product');
    }
    
});
