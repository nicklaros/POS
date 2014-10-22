Ext.define('POS.view.product.EditController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.edit-product',

    control: {
        'textfield[tabOnEnter = true]': {
            specialkey: function(field, e){
                if(e.getKey() == e.ENTER) field.next('field').focus();
            }
        },
        'textfield[saveOnEnter = true]': {
            specialkey: function(field, e){
                field.fireEvent('blur', field);
                if(e.getKey() == e.ENTER) this.save();
            }
        }
    },

    close: function(){
        this.getView().close();
    },

    load: function(id){
        var panel = this.getView(),
            form = this.lookupReference('form');

        POS.fn.App.setLoading(true);
        Ext.ws.Main.send('product/loadFormEdit', {id: id});
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('product/loadFormEdit', function(websocket, result){
                clearTimeout(monitor);
                POS.fn.App.setLoading(false);
                if (result.success){
                    form.getForm().setValues(result.data);
                    
                    this.lookupReference('name').focus();
                }else{
                    panel.close();
                    POS.fn.App.notification('Ups', result.errmsg);
                }
            }, this, {
                single: true,
                destroyable: true
            }),
            panel
        );
    },

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values = form.getValues();

            POS.fn.App.setLoading(true);
            Ext.ws.Main.send('product/update', values);
            var monitor = POS.fn.WebSocket.monitor(
                Ext.ws.Main.on('product/update', function(websocket, data){
                    clearTimeout(monitor);
                    POS.fn.App.setLoading(false);
                    if (data.success){
                        panel.close();
                        POS.app.getStore('Product').load();
                        POS.app.getStore('Stock').load();
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
});
