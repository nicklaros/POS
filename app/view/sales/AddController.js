Ext.define('POS.view.sales.AddController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.add-sales',

    control: {
        '#': {
            boxready: function(){
                var add = this.lookupReference('add');
                setTimeout(function(){
                    add.focus();
                }, 10);
            }
        },
        'textfield[saveOnEnter = true]': {
            specialkey: function(field, e){
                if(e.getKey() == e.ENTER) this.save();
            }
        },
        'grid-sales-detail': {
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
        Ext.fn.App.window('add-sales-detail');
    },

    close: function(){
        this.getView().close();
    },

    edit: function(){
        var rec = this.lookupReference('grid-sales-detail').getSelectionModel().getSelection()[0];

        var edit = Ext.fn.App.window('add-sales-detail');
        edit.isEdit = true;
        edit.getController().load(rec);
    },

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values = form.getValues();

            Ext.fn.App.setLoading(true);
            Ext.ws.Main.send('sales/create', values);
            var monitor = Ext.fn.WebSocket.monitor(
                Ext.ws.Main.on('sales/create', function(websocket, data){
                    clearTimeout(monitor);
                    Ext.fn.App.setLoading(false);
                    if (data.success){
                        panel.close();
                        POS.app.getStore('POS.store.Sales').load();
                    }else{
                        setTimeout(function(){
                            Ext.fn.App.notification('Ups', data.errmsg);
                        }, 10);
                    }
                }, this, {
                    single: true,
                    destroyable: true
                })
            );
        }
    }
});
