Ext.define('POS.view.currentuser.UpdateBiodataController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.update-biodata',

    requires: [
        'POS.fn.Util'
    ],

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
        var	form   = panel.down('form');
        
        panel.setLoading(true);
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('option/loadBiodata', function(websocket, result){
                clearTimeout(monitor);
                panel.setLoading(false);
                if (result.success){
                    form.getForm().setValues(result.data);
                    
                    var name = panel.down('[name = name]');
                    setTimeout(function(){
                        name.focus();
                    }, 10);
                }else{
                    POS.fn.App.notification('Ups', result.errmsg);
                    panel.close();
                }
            }, this, {
                single: true,
                destroyable: true
            }),
            panel,
            true
        );
        Ext.ws.Main.send('option/loadBiodata', {});
    },

    save: function(){
        var	panel  = this.getView(),
            form   = panel.down('form');

        if(form.getForm().isValid()){
            var params = form.getValues();
            
            panel.setLoading(true);
            var monitor = POS.fn.WebSocket.monitor(
                Ext.ws.Main.on('option/updateBiodata', function(websocket, data){
                    clearTimeout(monitor);
                    panel.setLoading(false);
                    if (data.success){
                        Ext.main.ViewModel.set('current_user.name', params.name);
                        Ext.main.ViewModel.set('current_user.address', params.address);
                        Ext.main.ViewModel.set('current_user.phone', params.phone);
                        panel.close();
                    }else{
                        POS.fn.App.notification('Ups', data.errmsg);
                    }
                }, this, {
                    single: true,
                    destroyable: true
                }),
                panel,
                false
            );
            Ext.ws.Main.send('option/updateBiodata', params);
        }
    }
});
