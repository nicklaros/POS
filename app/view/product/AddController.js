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

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values = form.getValues();

            POS.fn.App.setLoading(true);
            var monitor = POS.fn.WebSocket.monitor(
                Ext.ws.Main.on('product/create', function(websocket, result){
                    clearTimeout(monitor);
                    POS.fn.App.setLoading(false);
                    if (result.success){
                        panel.close();
                        POS.app.getStore('Product').load();
                        POS.app.getStore('Stock').load();
                        
                        var bindCombo = Ext.getCmp(panel.bindCombo);
                        
                        if (!Ext.isEmpty(bindCombo) && (bindCombo.xtype == 'combo-product')) {                            
                            var product = Ext.create('POS.model.Product', result.data);
                            
                            bindCombo.getStore().add(product);
                            
                            bindCombo.select(product);
                            
                            bindCombo.fireEvent('select', bindCombo, [product]);
                        }
                    }else{
                        POS.fn.App.notification('Ups', result.errmsg);
                    }
                }, this, {
                    single: true,
                    destroyable: true
                })
            );
            Ext.ws.Main.send('product/create', values);
        }
    }
});
