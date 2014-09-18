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

    addProduct: function(){
        var panel = Ext.fn.App.window('add-product');

        panel.bindCombo = this.lookupReference('product').getId();
    },

    addUnit: function(){
        var panel = Ext.fn.App.window('add-unit');

        panel.bindCombo = this.lookupReference('unit').getId();
    },

    comboChange: function(combo){
        if (combo.getValue() == null) combo.reset();
    },

    close: function(){
        this.getView().close();
    },
    
    onKeyAmount: function(field, e){
        if(e.getKey() == e.ENTER) this.lookupReference('buy').focus(true);
    },
    
    onKeyBuy: function(field, e){
        if(e.getKey() == e.ENTER) this.lookupReference('sell_public').focus(true);
    },
    
    onKeyMisc: function(field, e){
        if(e.getKey() == e.ENTER) this.lookupReference('discount').focus(true);
    },
    
    onChangeUnlimited: function(field, value){
        this.lookupReference('amount').setDisabled(value);
    },
    
    onSelectProduct: function(combo, record){
        this.lookupReference('unit').focus(true);
    },
    
    onSelectUnit: function(combo, record){
        this.lookupReference('amount').focus(true);
    },

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values = form.getValues();

            Ext.fn.App.setLoading(true);
            Ext.ws.Main.send('stock/create', values);
            var monitor = Ext.fn.WebSocket.monitor(
                Ext.ws.Main.on('stock/create', function(websocket, data){
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
