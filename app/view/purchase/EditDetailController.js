Ext.define('POS.view.purchase.EditDetailController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.edit-purchase-detail',

    control: {
        '#': {
            hide: function(){
                // remove combo stock's store
                this.lookupReference('stock').getStore().removeAll();

                setTimeout(function(){
                    // focus on combo product
                    Ext.ComponentQuery.query('edit-purchase [name = product]')[0].focus();
                }, 10);
            }
        },
        'textfield[saveOnEnter = true]': {
            specialkey: function(f, e){
                if(e.getKey() == e.ENTER) {
                    var me = this;
                
                    setTimeout(function(){
                        me.save();
                    }, 10);
                }
            }
        }
    },

    addProduct: function(){
        var panel = POS.fn.App.window('add-product');

        panel.bindCombo = this.lookupReference('product').getId();
    },

    addVariant: function(){
        var product = this.lookupReference('product').getSelectedRecord();
            
        // make sure product is selected
        if (!Ext.isEmpty(product)) {
            var panel           = POS.fn.App.window('add-stock'),
                panelController = panel.getController();
            
            panel.bindCombo = this.lookupReference('stock').getId();
            
            var comboProduct = panelController.lookupReference('product');            
            comboProduct.setValue(product);
            comboProduct.setReadOnly(true);
            
            panelController.lookupReference('add_product').hide();
            
            setTimeout(function(){
                panelController.lookupReference('unit').focus();
            }, 10);
        } else {
            POS.fn.App.notification('Ups', 'Pilih Produk terlebih dahulu');
        }
    },

    close: function(){
        var panel = this.getView(),
            form = panel.down('form');
        
        panel.hide();
        
        form.reset();
    },

    load: function(record){
        var panel = this.getView(),
            form = panel.down('form');
        
        // save reference to edited record
        panel.record = record.get('id');

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
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('populate/stock', function(websocket, result){
                clearTimeout(monitor);
                if (result.success){
                    POS.app.getStore('combo.Stock').loadData(result.data);
                }else{
                    POS.fn.App.notification('Ups', result.errmsg);
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
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('stock/getOne', function(websocket, result){
                clearTimeout(monitor);
                if (result.success){
                    this.onSetValueStock(result.data);
                }else{
                    POS.fn.App.notification('Ups', result.errmsg);
                }
            }, this, {
                single: true,
                destroyable: true
            })
        );
        Ext.ws.Main.send('stock/getOne', params);
    },
    
    onChangeProduct: function(combo){
        if (combo.getRawValue() == '') {
            combo.clear();
            this.onClearProduct();
        }
    },
    
    onClearProduct: function(){
        var stock = this.lookupReference('stock');
        
        stock.clear();
        stock.getStore().removeAll();
    },
    
    onSelectProduct: function(combo, record){
        var params = {
            product_id: record[0].getData().id
        }
        
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('populate/stock', function(websocket, result){
                clearTimeout(monitor);
                if (result.success){
                    this.onClearProduct();
                    
                    POS.app.getStore('combo.Stock').loadData(result.data);
                    
                    var resultLength = result.data.length;
                    
                    if (resultLength == 0) {
                        this.addVariant();
                        
                    } else if (resultLength == 1) {
                        var stock = Ext.create('POS.model.Stock', result.data[0]);
                        
                        var comboStock = this.lookupReference('stock');
                        
                        comboStock.select(stock);
                        comboStock.fireEvent('setvalue', stock.getData());
                        
                    } else {
                        this.lookupReference('stock').focus(true);
                    }
                }else{
                    POS.fn.App.notification('Ups', result.errmsg);
                }
            }, this, {
                single: true,
                destroyable: true
            })
        );
        Ext.ws.Main.send('populate/stock', params);
    },
    
    onClearStock: function(){
        this.lookupReference('unit').setHtml('');        
        this.lookupReference('detail_container').hide();
    },
    
    onSelectStock: function(combo, record){
        this.onSetValueStock(record[0].getData());
    },
    
    onSetValueStock: function(value){
        this.getViewModel().set('stock', value);
        
        this.setUnitPrice();
    
        this.lookupReference('unit').setHtml(value.unit_name);
        this.lookupReference('detail_container').show();
        this.lookupReference('amount').focus(true);
    },

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(
            form.getForm().isValid()
            &&
            this.lookupReference('total_price').getSubmitValue() != 0
        ){
            var values = form.getValues(),
                viewModelData = this.getViewModel().getData();
            
            delete values.id;
            
            values.stock_id = values.stock;
            values.product_id = values.product;
            values.product_name = viewModelData.stock.product_name;
            values.unit_name = viewModelData.stock.unit_name;
            values.unit_price = parseInt(values.total_price / values.amount);
            
            // update record
            POS.app.getStore('purchase.EditDetail').getById(panel.record).set(values);
            
            // hide panel
            panel.hide();

            // reset form
            form.reset();
            
            // reset price status
            this.lookupReference('price_status').update({});
            
            // get reference to add-sales panel and it's controller
            var editPurchase = Ext.ComponentQuery.query('edit-purchase')[0],
                editPurchaseController = editPurchase.getController();
            
            // set total price
            editPurchaseController.setTotalPrice();
            
            // focus on combo product
            editPurchaseController.lookupReference('product').focus();
        }
    },
    
    setUnitPrice: function(){
        var totalPrice      = this.lookupReference('total_price'),
            amount          = this.lookupReference('amount'),
            unitPrice       = this.lookupReference('unit_price'),
            value           = parseInt(totalPrice.getSubmitValue() / amount.getValue()),
            priceDifference = this.getViewModel().get('stock.buy') - value,
            params          = {};
            
        unitPrice.setHtml(POS.fn.Render.currency(value));
        
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
