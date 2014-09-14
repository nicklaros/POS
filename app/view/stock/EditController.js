Ext.define('POS.view.stock.EditController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.edit-stock',

    control: {
        'textfield[saveOnEnter = true]': {
            specialkey: function(f, e){
                if(e.getKey() == e.ENTER) this.save();
            }
        }
    },

    close: function(){
        this.getView().close();
    },
    
    onChangeUnlimited: function(field, value){
        this.lookupReference('amount').setDisabled(value);
    },

    load: function(id){
        var panel = this.getView(),
            form = this.lookupReference('form');

        Ext.fn.App.setLoading(true);
        Ext.ws.Main.send('stock/loadFormEdit', {id: id});
        var monitor = Ext.fn.WebSocket.monitor(
            Ext.ws.Main.on('stock/loadFormEdit', function(websocket, result){
                clearTimeout(monitor);
                Ext.fn.App.setLoading(false);
                if (result.success){
                    var product = new POS.model.Product;
                    product.set('id', result.data.product_id);
                    product.set('name', result.data.product_name);
                    result.data.product_id = product;
                
                    var unit = new POS.model.Unit;
                    unit.set('id', result.data.unit_id);
                    unit.set('name', result.data.unit_name);
                    result.data.unit_id = unit;
                
                    form.getForm().setValues(result.data);
                    
                    this.lookupReference('product').focus();
                }else{
                    panel.close();
                    Ext.fn.App.notification('Ups', result.errmsg);
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

            Ext.fn.App.setLoading(true);
            Ext.ws.Main.send('stock/update', values);
            var monitor = Ext.fn.WebSocket.monitor(
                Ext.ws.Main.on('stock/update', function(websocket, data){
                    clearTimeout(monitor);
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
