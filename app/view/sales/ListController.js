Ext.define('POS.view.sales.ListController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.list-sales',

    control: {
        '#': {
            boxready: function(panel){
                
            },
            selectionchange: function(sm, selected){
                var btnEdit = this.lookupReference('edit'),
                    btnDelete = this.lookupReference('delete'),
                    btnPrint = this.lookupReference('print');

                btnEdit.setDisabled(selected.length !== 1);
                btnDelete.setDisabled(selected.length === 0);
                btnPrint.setDisabled(selected.length !== 1);
            },
            celldblclick: function(){
                this.edit();
            }
        }
    },
    
    add: function(){
        Ext.fn.App.window('add-sales');
    },

    print: function(){
        var rec  = this.getView().getSelectionModel().getSelection()[0];

        Ext.fn.App.printNotaSales(rec.get('id'));
    },
    
    remove: function(){
        var sm      = this.getView().getSelectionModel(),
            sel     = sm.getSelection(),
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
                    Ext.ws.Main.send('sales/destroy', {id: id});
                    var monitor = Ext.fn.WebSocket.monitor(
                        Ext.ws.Main.on('sales/destroy', function(websocket, data){
                            clearTimeout(monitor);
                            Ext.fn.App.setLoading(false);
                            if (data.success){
                                POS.app.getStore('POS.store.Sales').load();
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
        var rec     = this.getView().getSelectionModel().getSelection()[0],
            params  = {
                id: rec.get('id')
            };

        var edit = Ext.fn.App.window('edit-sales');
        edit.getController().load(params);
    },
    
    search: function(){
        Ext.fn.App.window('search-sales');
    },
    
    reset: function(){
        this.getView().getStore().search({});
    }
});
