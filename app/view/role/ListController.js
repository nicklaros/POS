Ext.define('POS.view.role.ListController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.list-role',

    requires: [
        'POS.fn.Util'
    ],

    control: {
        '#': {
            selectionchange: function(sm, selected){
                var btnEdit             = this.lookupReference('edit'),
                    btnPermission       = this.lookupReference('permission'),
                    btnDelete           = this.lookupReference('delete');

                btnEdit.setDisabled(selected.length !== 1);
                btnPermission.setDisabled(selected.length !== 1);
                btnDelete.setDisabled(selected.length === 0);
            },
            celldblclick: 'edit',
            itemcontextmenu: 'showMenu'
        }
    },
    
    add: function(){
        POS.fn.App.window('add-role');
    },

    edit: function(){
        var rec = this.getView().getSelectionModel().getSelection()[0];

        var edit = POS.fn.App.window('edit-role');
        edit.getController().load(rec.get('id'));
    },
    
    notificationOption: function(){
        POS.fn.App.window('notification-option');
    },
    
    permission: function(){
        var rec = this.getView().getSelectionModel().getSelection()[0];

        var edit = POS.fn.App.window('role-permission');
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
                    var params = {
                        id: id
                    }

                    POS.fn.App.setLoading(true);
                    var monitor = POS.fn.WebSocket.monitor(
                        Ext.ws.Main.on('role/destroy', function(websocket, result){
                            clearTimeout(monitor);
                            POS.fn.App.setLoading(false);
                            if (result.success){
                                POS.app.getStore('Role').load();
                            }else{
                                POS.fn.App.notification('Ups', result.errmsg);
                            }
                        }, this, {
                            single: true,
                            destroyable: true
                        })
                    );
                    Ext.ws.Main.send('role/destroy', params);
                }
            }
        );
    },
    
    reset: function(){
        this.getView().getStore().search({});
    },
    
    search: function(){
        POS.fn.App.window('search-role');
    },
    
    showMenu: function(view, record, item, index, e, eOpts) {
        var me = this;
        
        e.stopEvent();
        if (!me.menu) {
            me.menu = new Ext.menu.Menu({
                plain: true,
                items : [{
                    text: '<i class="fa fa-edit main-nav-icon"></i> Ubah Nama Jabatan',
                    handler: function(){
                        me.edit();
                    }
                },{
                    text: '<i class="fa fa-check-square-o main-nav-icon"></i> Ubah Hak Akses',
                    handler: function(){
                        me.permission();
                    }
                },{
                    text: '<i class="fa fa-trash-o main-nav-icon"></i> Hapus Jabatan',
                    handler: function(){
                        me.remove();
                    }
                }]
            });
        }
        me.menu.showAt(e.getXY());
    }
    
});
