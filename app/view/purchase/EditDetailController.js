Ext.define('POS.view.purchase.EditDetailController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.edit-purchase-detail',

    control: {
        '#': {
            boxready: function(panel){
                var product = this.lookupReference('product');
                
                setTimeout(function(){
                    product.focus();
                }, 10);
            },
            close: function(){
                POS.app.getStore('POS.store.combo.Stock').removeAll();
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

    addVariant: function(){
        var product = this.lookupReference('product').getSelectedRecord();
            
        // make sure product is selected
        if (!Ext.isEmpty(product)) {
            var panel = Ext.widget('add-stock-variant')
            
            panel.bindCombo = this.lookupReference('stock');
            panel.setTitle(panel.getTitle() + product.get('name'));
            panel.down('[name = product_id]').setValue(product.get('id'));
        } else {
            Ext.fn.App.notification('Ups', 'Pilih Produk terlebih dahulu');
        }
    },

    close: function(){
        this.getView().close();
    },

    load: function(record){
        var panel = this.getView(),
            form = panel.down('form');

        var product = Ext.create('POS.model.Product', {
            id: record.get('product_id'),
            name: record.get('product_name')
        });

        record.set('product', product);

        var variant = Ext.create('POS.model.combo.Stock', {
            stock_id: record.get('stock_id'),
            unit_name: record.get('unit_name')
        });

        record.set('stock', variant);
        
        form.getForm().setValues(record.getData());
        
        var params = {
            product_id: record.get('product_id')
        }
        var monitor = Ext.fn.WebSocket.monitor(
            Ext.ws.Main.on('populate/stock', function(websocket, result){
                clearTimeout(monitor);
                if (result.success){
                    POS.app.getStore('POS.store.combo.Stock').loadData(result.data);
                }else{
                    Ext.fn.App.notification('Ups', result.errmsg);
                }
            }, this, {
                single: true,
                destroyable: true
            })
        );
        Ext.ws.Main.send('populate/stock', params);
        
        var params = {
            id: record.get('stock_id')
        }        
        var monitor = Ext.fn.WebSocket.monitor(
            Ext.ws.Main.on('stock/getOne', function(websocket, result){
                clearTimeout(monitor);
                if (result.success){
                    this.onStockSetValue(result.data);
                }else{
                    Ext.fn.App.notification('Ups', result.errmsg);
                }
            }, this, {
                single: true,
                destroyable: true
            })
        );
        Ext.ws.Main.send('stock/getOne', params);
    },
    
    onProductChange: function(combo){
        if (combo.getRawValue() == '') {
            combo.clear();
            this.onProductClear();
        }
    },
    
    onProductClear: function(){
        var stock = this.lookupReference('stock');
        
        stock.clear();
        stock.getStore().removeAll();
    },
    
    onProductSelect: function(combo, record){
        var params = {
            product_id: record[0].getData().id
        }
        
        var monitor = Ext.fn.WebSocket.monitor(
            Ext.ws.Main.on('populate/stock', function(websocket, result){
                clearTimeout(monitor);
                if (result.success){
                    this.onProductClear();
                    
                    POS.app.getStore('POS.store.combo.Stock').loadData(result.data);
                    
                    var resultLength = result.data.length;
                    
                    if (resultLength == 0) {
                        this.lookupReference('add_variant').focus();
                        
                    } else if (resultLength == 1) {
                        var stock = Ext.create('POS.model.Stock', result.data[0]);
                        
                        var comboStock = this.lookupReference('stock');
                        
                        comboStock.select(stock);
                        comboStock.fireEvent('setvalue', stock.getData());
                        
                    } else {
                        this.lookupReference('stock').focus(true);
                    }
                }else{
                    Ext.fn.App.notification('Ups', result.errmsg);
                }
            }, this, {
                single: true,
                destroyable: true
            })
        );
        Ext.ws.Main.send('populate/stock', params);
    },
    
    onStockClear: function(){
        this.lookupReference('unit').setHtml('');        
        this.lookupReference('detail_container').hide();
    },
    
    onStockSelect: function(combo, record){
        this.onStockSetValue(record[0].getData());
    },
    
    onStockSetValue: function(value){
        this.getViewModel().set('stock', value);
        
        this.setUnitPrice();
    
        this.lookupReference('unit').setHtml(value.unit_name);
        this.lookupReference('detail_container').show();
        this.lookupReference('amount').focus(true);
    },

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values = form.getValues(),
                viewModelData = this.getViewModel().getData();
            
            values.stock_id = values.stock;
            values.product_id = values.product;
            values.product_name = viewModelData.stock.product_name;
            values.unit_name = viewModelData.stock.unit_name;
            values.unit_price = parseInt(values.total_price / values.amount);
            
            if (!panel.isEdit) {            
                var store = POS.app.getStore('POS.store.PurchaseDetail'),
                    rec = Ext.create('POS.model.PurchaseDetail');
                    
                rec.set(values);
                store.add(rec);
            }else{
                // perhaps there is a better way to select currently edited record than this clumsy code below
                var rec = Ext.ComponentQuery.query('edit-purchase grid-purchase-detail')[0].getSelectionModel().getSelection()[0];
                rec.set(values);
            }

            panel.close();
            
            Ext.ComponentQuery.query('edit-purchase')[0].getController().setTotalPrice();
        }
    },
    
    setUnitPrice: function(){
        var totalPrice      = this.lookupReference('total_price'),
            amount          = this.lookupReference('amount'),
            unitPrice       = this.lookupReference('unit_price'),
            value           = parseInt(totalPrice.getSubmitValue() / amount.getValue()),
            priceDifference = this.getViewModel().get('stock.buy') - value,
            params          = {};
            
        unitPrice.setHtml(Ext.fn.Render.currency(value));
        
        if (priceDifference == 0) {
            params.status = 'stagnant';
            params.amount = 0;
            
        } else if (priceDifference > 0) {
            params.status = 'down';
            params.amount = priceDifference;
            
        } else if (priceDifference < 0) {
            params.status = 'up';
            params.amount = Math.abs(priceDifference);
        }
        
        this.lookupReference('price_status').update(params);
    }
});
