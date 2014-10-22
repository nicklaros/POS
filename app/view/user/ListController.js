Ext.define('POS.view.user.ListController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.list-user',

    requires: [
        'POS.fn.Util'
    ],

    control: {
        '#': {
            selectionchange: function(sm, selected){
                var btnEdit = this.lookupReference('edit'),
                    btnResetPassword = this.lookupReference('resetPassword'),
                    btnDelete = this.lookupReference('delete');

                btnEdit.setDisabled(selected.length !== 1);
                btnResetPassword.setDisabled(selected.length !== 1);
                btnDelete.setDisabled(selected.length === 0);
            },
            celldblclick: 'edit',
            itemcontextmenu: 'showMenu'
        }
    },
    
    add: function(){
        POS.fn.App.window('add-user');
    },

    edit: function(){
        var rec = this.getView().getSelectionModel().getSelection()[0];

        var edit = POS.fn.App.window('edit-user');
        edit.getController().load(rec.get('id'));
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
                    Ext.ws.Main.send('user/destroy', {id: id});
                    var monitor = POS.fn.WebSocket.monitor(
                        Ext.ws.Main.on('user/destroy', function(websocket, data){
                            clearTimeout(monitor);
                            POS.fn.App.setLoading(false);
                            if (data.success){
                                POS.app.getStore('User').load();
                            }else{
                                POS.fn.App.notification('Ups', data.errmsg);
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
    
    reset: function(){
        this.getView().getStore().search({});
    },
    
    resetPassword: function(){
        var rec = this.getView().getSelectionModel().getSelection()[0];

        Ext.Msg.confirm(
            '<i class="fa fa-exclamation-triangle glyph"></i> Reset Password',
            '<b>Password user ' + rec.get('name') + ' akan direset sama dengan "User ID" nya. <br /> Lanjutkan?</b><br>',
            function(btn){
                if (btn == 'yes'){
                    POS.fn.App.setLoading(true);
                    Ext.ws.Main.send('user/resetPassword', {id: rec.get('id')});
                    var monitor = POS.fn.WebSocket.monitor(
                        Ext.ws.Main.on('user/resetPassword', function(websocket, data){
                            clearTimeout(monitor);
                            POS.fn.App.setLoading(false);
                            if (data.success){
                                POS.fn.App.notification('Berhasil', 'Password berhasil direset, selanjutnya user tersebut bisa masuk dengan password yang sama dengan User Id nya');
                            }else{
                                POS.fn.App.notification('Ups', data.errmsg);
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
    
    search: function(){
        POS.fn.App.window('search-user');
    },
    
    showMenu: function(view, record, item, index, e, eOpts) {
        var me = this;
        
        e.stopEvent();
        if (!me.menu) {
            me.menu = new Ext.menu.Menu({
                plain: true,
                items : [{
                    text: '<i class="fa fa-edit main-nav-icon"></i> Ubah Data Pegawai',
                    handler: function(){
                        me.edit();
                    }
                },{
                    text: '<i class="fa fa-key main-nav-icon"></i> Reset Password Pegawai',
                    handler: function(){
                        me.resetPassword();
                    }
                },{
                    text: '<i class="fa fa-trash-o main-nav-icon"></i> Hapus Pegawai',
                    handler: function(){
                        me.remove();
                    }
                }]
            });
        }
        me.menu.showAt(e.getXY());
    }
});
