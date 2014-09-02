Ext.define('POS.view.product.AddController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.add-product',

    control: {
        '#': {
            boxready: function(){
                var code = this.lookupReference('code');
                setTimeout(function(){
                    code.focus();
                }, 10);
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

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values = form.getValues();

            Ext.fn.App.setLoading(true);
            Ext.ws.Main.send('product/create', values);
            var monitor = Ext.fn.WebSocket.monitor(
                Ext.ws.Main.on('product/create', function(websocket, data){
                    clearTimeout(monitor);
                    Ext.fn.App.setLoading(false);
                    if (data.success){
                        panel.close();
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
});
