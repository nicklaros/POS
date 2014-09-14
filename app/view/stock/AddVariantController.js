Ext.define('POS.view.stock.AddVariantController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.add-stock-variant',

    control: {
        '#': {
            boxready: function(){
                var unit = this.lookupReference('unit');
                setTimeout(function(){
                    unit.focus();
                }, 10);
            }
        },
        'textfield[saveOnEnter = true]': {
            specialkey: function(f, e){
                if(e.getKey() == e.ENTER) this.save();
            }
        }
    },

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values = form.getValues();
            
            values.unit_id = values.unit;

            Ext.fn.App.setLoading(true);
            var monitor = Ext.fn.WebSocket.monitor(
                Ext.ws.Main.on('stock/addVariant', function(websocket, result){
                    clearTimeout(monitor);
                    Ext.fn.App.setLoading(false);
                    if (result.success){
                        panel.close();
                        
                        var bindCombo = panel.bindCombo;
                        
                        if (!Ext.isEmpty(bindCombo) && (bindCombo.xtype == 'combo-stock-variant')) {
                            result.data.stock_id = result.data.id;
                            
                            var stock = Ext.create('POS.model.Stock', result.data);
                            
                            bindCombo.getStore().add(stock);
                            
                            bindCombo.select(stock);
                            
                            bindCombo.fireEvent('setvalue', result.data);
                        }
                    }else{
                        Ext.fn.App.notification('Ups', result.errmsg);
                    }
                }, this, {
                    single: true,
                    destroyable: true
                })
            );
            Ext.ws.Main.send('stock/addVariant', values);
        }
    }
});
