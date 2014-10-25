Ext.define('POS.view.option.IdentityController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.option-identity',

    control: {
        '#': {
            boxready: 'load'
        },
        'textfield[tabOnEnter = true]': {
            specialkey: function(field, e){
                if(e.getKey() == e.ENTER) field.next('field').focus();
            }
        },
        'textfield[saveOnEnter = true]': {
            specialkey: function(f, e){
                if(e.getKey() == e.ENTER) this.save();
            }
        }
    },

    close: function(){
        this.getView().close();
    },
    
    load: function(panel){
        var	me      = this,
            form    = panel.down('form');
        
        panel.setLoading(true);
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('option/loadClientIdentity', function(websocket, result){
                clearTimeout(monitor);
                panel.setLoading(false);
                if (result.success){
                    form.getForm().setValues(result.data);
                    
                    var name = panel.down('[name = client_name]');
                    setTimeout(function(){
                        name.focus();
                    }, 10);
                }else{
                    POS.fn.App.notification('Ups', result.errmsg);
                    me.lookupReference('status').setHtml('<span class="red">Gagal membaca data dari server</span>');
                }
            }, this, {
                single: true,
                destroyable: true
            }),
            panel,
            true
        );
        Ext.ws.Main.send('option/loadClientIdentity', {});
    },

    saveIdentity: function(){
        var	me     = this,
            panel  = this.getView(),
            form   = panel.down('form');

        if(form.getForm().isValid()){
            var params = form.getValues();
            
            panel.setLoading(true);
            var monitor = POS.fn.WebSocket.monitor(
                Ext.ws.Main.on('option/updateClientIdentity', function(websocket, data){
                    clearTimeout(monitor);
                    panel.setLoading(false);
                    if (data.success){
                        Ext.main.ViewModel.set('info.client_name', params.client_name);
                        Ext.main.ViewModel.set('info.client_address', params.client_address);
                        Ext.main.ViewModel.set('info.client_phone', params.client_phone);
                        Ext.main.ViewModel.set('info.client_email', params.client_email);
                        Ext.main.ViewModel.set('info.client_website', params.client_website);
                        
                        var appHeader = Ext.main.View.down('#app-header');
                        appHeader.update(Ext.main.ViewModel.get('info'));
                        
                        me.lookupReference('status').setHtml('<span class="green">Pengaturan berhasil tersimpan</span>');
                    }else{
                        POS.fn.App.notification('Ups', data.errmsg);
                        
                        me.lookupReference('status').setHtml('<span class="red">Gagal menyimpan</span>');
                    }
                }, this, {
                    single: true,
                    destroyable: true
                }),
                panel,
                false
            );
            Ext.ws.Main.send('option/updateClientIdentity', params);
        }
    }
    
});