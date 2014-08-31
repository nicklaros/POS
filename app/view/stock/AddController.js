Ext.define('POS.view.stock.AddController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.add-stock',

    control: {
        '#': {
            boxready: function(){
                var product = this.lookupReference('product');
                setTimeout(function(){
                    product.focus();
                }, 10);
            }
        },
        'numberfield': {
            specialkey: function(f, e){
                if(e.getKey() == e.ENTER) this.save();
            }
        }
    },

    comboChange: function(combo){
        if (combo.getValue() == null) combo.reset();
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
            Ext.ws.Main.send('stock/create', values);
            Ext.fn.WebSocket.monitor(
                Ext.ws.Main.on('stock/create', function(websocket, data){
                    Ext.fn.App.setLoading(false);
                    if (data.success){
                        panel.close();
                        POS.app.getStore('POS.store.Stock').load();
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
