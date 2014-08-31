Ext.define('POS.view.user.ListController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.list-user',

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
                    btnResetPassword = this.lookupReference('resetPassword'),
                    btnDelete = this.lookupReference('delete');

                btnEdit.setDisabled(selected.length !== 1);
                btnResetPassword.setDisabled(selected.length !== 1);
                btnDelete.setDisabled(selected.length === 0);
            },
            celldblclick: function(){
                this.edit();
            }
        },
        'button[reference=add]': {
            click: function(){
                Ext.fn.App.window('add-user')
            }
        },
        'button[reference=edit]': {
            click: function(){
                this.edit();
            }
        },
        'button[reference=resetPassword]': {
            click: function(){
                var rec = this.getView().getSelectionModel().getSelection()[0];

                Ext.Msg.confirm(
                    '<i class="fa fa-exclamation-triangle glyph"></i> Reset Password',
                    '<b>Password user ' + rec.get('nama') + ' akan direset sama dengan "User ID" nya. <br /> Lanjutkan?</b><br>',
                    function(btn){
                        if (btn == 'yes'){
                            Ext.fn.App.setLoading(true);
                            Ext.ws.Main.send('user/resetPassword', {id: rec.get('id')});
                            Ext.fn.WebSocket.monitor(
                                Ext.ws.Main.on('user/resetPassword', function(websocket, data){
                                    Ext.fn.App.setLoading(false);
                                    if (data.success){
                                        Ext.fn.App.notification('Berhasil', 'Password berhasil direset, selanjutnya user tersebut bisa masuk dengan password yang sama dengan User Id nya');
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
            }
        },
        'button[reference=delete]': {
            click: function(){
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
                            Ext.ws.Main.send('user/destroy', {id: id});
                            Ext.fn.WebSocket.monitor(
                                Ext.ws.Main.on('user/destroy', function(websocket, data){
                                    Ext.fn.App.setLoading(false);
                                    if (data.success){
                                        POS.app.getStore('POS.store.User').load();
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
            }
        },
        'button[reference=search]': {
            click: function(){
                Ext.fn.App.window('search-user');
            }
        },
        'button[reference=reset]': {
            click: function(){
                this.getView().getStore().search({});
            }
        }
    },

    edit: function(){
        var rec = this.getView().getSelectionModel().getSelection()[0];

        var edit = Ext.fn.App.window('edit-user');
        edit.getController().load(rec.get('id'));
    }
});
