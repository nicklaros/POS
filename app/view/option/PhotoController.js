Ext.define('POS.view.option.PhotoController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.option-photo',

    control: {
        '#': {
            boxready: 'load'
        }
    },
    
    load: function(panel){
        var	me      = this,
            form    = panel.down('form');
        
        panel.setLoading(true);
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('option/loadAppPhoto', function(websocket, result){
                clearTimeout(monitor);
                panel.setLoading(false);
                if (result.success){
                    Ext.main.ViewModel.set('info.app_photo', result.data.app_photo);
                }else{
                    POS.fn.App.notification('Ups', result.errmsg);
                }
            }, this, {
                single: true,
                destroyable: true
            }),
            panel,
            true
        );
        Ext.ws.Main.send('option/loadAppPhoto', {});
    },
    
    save: function(){
        var	panel  = this.getView(),
            form   = panel.down('form');

        if(form.getForm().isValid()){
            panel.setLoading(true);
            form.getForm().submit({
                submitEmptyText: false,
                success : function(form, action){
                    panel.setLoading(false);
                    Ext.main.ViewModel.set('info.app_photo', action.result.photo);
                },
                failure : function(form, action){
                    panel.setLoading(false);
                }
            })
        }
    }
    
});