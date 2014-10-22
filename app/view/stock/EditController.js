Ext.define('POS.view.stock.EditController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.edit-stock',

    control: {
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
        var panel = POS.fn.App.window('add-product');

        panel.bindCombo = this.lookupReference('product').getId();
    },

    addUnit: function(){
        var panel = POS.fn.App.window('add-unit');

        panel.bindCombo = this.lookupReference('unit').getId();
    },

    close: function(){
        this.getView().close();
    },
    
    onKeyAmount: function(field, e){
        if(e.getKey() == e.ENTER) this.lookupReference('discount').focus(true);
    },
    
    onKeyBuy: function(field, e){
        if(e.getKey() == e.ENTER) this.lookupReference('amount').focus(true);
    },
    
    onKeyMisc: function(field, e){
        if(e.getKey() == e.ENTER) this.lookupReference('buy').focus(true);
    },
    
    onChangeUnlimited: function(field, value){
        this.lookupReference('amount').setDisabled(value);
    },
    
    onSelectProduct: function(combo, record){
        this.lookupReference('unit').focus(true);
    },
    
    onSelectUnit: function(combo, record){
        this.lookupReference('sell_public').focus(true);
    },


    load: function(id){
        var panel = this.getView(),
            form = this.lookupReference('form');

        POS.fn.App.setLoading(true);
        Ext.ws.Main.send('stock/loadFormEdit', {id: id});
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('stock/loadFormEdit', function(websocket, result){
                clearTimeout(monitor);
                POS.fn.App.setLoading(false);
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
            Ext.ws.Main.send('stock/update', values);
            var monitor = POS.fn.WebSocket.monitor(
                Ext.ws.Main.on('stock/update', function(websocket, data){
                    clearTimeout(monitor);
                    POS.fn.App.setLoading(false);
                    if (data.success){
                        panel.close();
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
    },
    
    setDiscountPercentage: function(){
        var discountPercentage  = this.lookupReference('discount'),
            discountNumber      = this.lookupReference('discount_in_number'),
            sellPublic          = this.lookupReference('sell_public'),
            result              = 0;
        
        if (sellPublic.getSubmitValue() != 0) {
            result = discountNumber.getSubmitValue() * 100 / sellPublic.getSubmitValue();
        }
        
        discountPercentage.suspendEvents();
        discountPercentage.setValue(result);
        discountPercentage.resumeEvents(false);
    },
    
    setDiscountNumber: function(){
        var discountPercentage  = this.lookupReference('discount'),
            discountNumber      = this.lookupReference('discount_in_number'),
            sellPublic          = this.lookupReference('sell_public'),
            result              = 0;
        
        if (sellPublic.getSubmitValue() != 0) {
            result = discountPercentage.getSubmitValue() * sellPublic.getSubmitValue() / 100;
        }
        
        discountNumber.suspendEvents();
        discountNumber.setValue(Math.round(result));
        discountNumber.resumeEvents(false);
    }
    
});
