Ext.define('POS.view.purchase.AddController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.add-purchase',

    init: function() {
        this.listen({
            store: {
                '#purchase.AddDetail': {
                    add: 'refreshGrid',
                    remove: 'refreshGrid'
                }
            }
        });
    },

    control: {
        '#': {
            boxready: function(panel){
                this.setDefaultValue();

                this.keyMap(panel);
                
                this.focusProduct();
            },
            show: function(){
                var product = this.focusProduct();
                
                // if record on combo product is gone then reset form add detail
                if ( Ext.isEmpty(product.getSelectedRecord()) ) {
                    this.lookupReference('formAddDetail').reset();
                    
                    this.lookupReference('sub_total_price').setValue(0);
                }
            },
            hide: function(panel){
                var me = this;
                
                setTimeout(function(){
                    if ( Ext.isEmpty(Ext.main.AppTab.down('add-purchase')) ) {
                        // reset form
                        me.lookupReference('formPayment').reset();
                        me.lookupReference('formAddDetail').reset();
                        
                        // set default value
                        me.setDefaultValue();

                        // clear purchase detail store
                        POS.app.getStore('purchase.AddDetail').removeAll();
                    }
                }, 10);
            }
        },
        'grid-purchase-detail': {
            selectionchange: function(sm, selected){
                var btnEdit     = this.lookupReference('edit'),
                    btnDelete   = this.lookupReference('delete');

                btnEdit.setDisabled(selected.length !== 1);
                btnDelete.setDisabled(selected.length === 0);
            },
            celldblclick: 'edit',
            itemkeydown : function(view, record, item, index, key) {
                if (key.getKey() == 46) { //the delete button
                    this.remove();
                }  
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
    
    add: function(){
        this.lookupReference('product').focus(true);
    },

    addSecondParty: function(){
        var panel = POS.fn.App.window('add-second-party');

        panel.bindCombo = this.lookupReference('second_party').getId();
        
        panel.down('[name = type]').setValue('Supplier');
    },

    addProduct: function(){
        var panel = POS.fn.App.window('add-product');

        panel.bindCombo = this.lookupReference('product').getId();
    },

    addVariant: function(){
        var product = this.lookupReference('product'),
            record  = product.getSelectedRecord();
        
        // make sure a product is selected
        if (!Ext.isEmpty(record)) {
            var panel           = POS.fn.App.window('add-stock'),
                panelController = panel.getController();
            
            panel.bindCombo = this.lookupReference('stock').getId();
            
            var comboProduct = panelController.lookupReference('product');            
            comboProduct.setValue(record);
            comboProduct.setReadOnly(true);
            
            panelController.lookupReference('add_product').hide();
            
            setTimeout(function(){
                panelController.lookupReference('unit').focus();
            }, 10);
        } else {
            POS.fn.App.notification('Ups', 'Pilih Produk terlebih dahulu');
            
            this.focusProduct();
        }
    },

    close: function(){
        Ext.main.AppTab.remove('add-purchase');
    },

    edit: function(){
        var rec = this.lookupReference('grid-purchase-detail').getSelectionModel().getSelection()[0];

        var edit = POS.fn.App.window('add-purchase-detail');
        edit.getController().load(rec);
    },
    
    focusProduct: function(){
        var product = this.lookupReference('product');

        setTimeout(function(){
            product.focus(true);
        }, 10);
        
        return product;
    },
    
    keyMap: function(panel){
        var me = this;
        
        new Ext.util.KeyMap({
            target: panel.getEl(),
            binding: [{
                key: 27, // Esc
                defaultEventAction: 'preventDefault',
                fn: function(){ 
                    me.close();
                }
            },{
                key: 84, // Alt + T
                alt: true,
                defaultEventAction: 'preventDefault',
                fn: function(){ 
                    me.add();
                }
            },{
                key: 66, // Alt + B
                alt: true,
                defaultEventAction: 'preventDefault',
                fn: function(){ 
                    me.lookupReference('paid').focus(true);
                }
            },{
                key: 83, // Alt + S
                alt: true,
                defaultEventAction: 'preventDefault',
                fn: function(){ 
                    me.save();
                }
            }]
        });
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
        
        // populate stock and add it to combo stock variant
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('populate/stock', function(websocket, result){
                clearTimeout(monitor);
                if (result.success){
                    this.onProductClear();
                    
                    // add result to combo stock variant
                    POS.app.getStore('combo.Stock').loadData(result.data);
                    
                    var resultLength = result.data.length;
                    
                    if (resultLength == 0) {
                        // if empty result returned then add stock variant immediately
                        this.addVariant();
                        
                    } else if (resultLength == 1) {
                        // if only one result returned then automatically select it
                        var stock = Ext.create('POS.model.Stock', result.data[0]);
                        
                        var comboStock = this.lookupReference('stock');
                        
                        comboStock.select(stock);
                        
                        comboStock.fireEvent('select', comboStock, [stock]);
                        
                    } else {
                        // if two or more result returned then focus on combo stock variant
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
    
    onProductBlur: function(combo){
        if ( Ext.isEmpty(combo.getSelectedRecord()) ) combo.reset();
    },
    
    onStockSelect: function(combo, record){
        this.lookupReference('amount').focus(true);
    },
    
    onTotalPriceKey: function(f, e){
        if(e.getKey() == e.ENTER) {
            this.saveAddDetail();
        }
    },
    
    refreshGrid: function(){
        var grid = this.lookupReference('grid-purchase-detail');
        
        grid.getView().refresh();
    },
    
    remove: function(){
        var grid    = this.lookupReference('grid-purchase-detail'),
            store   = grid.getStore(),
            sm      = grid.getSelectionModel(),
            sel     = sm.getSelection(),
            smCount = sm.getCount(),
            me      = this;
            
        // remove selected record
        store.remove(sel[0]);

        // update total price
        me.setTotalPrice();
        
        // focus on combo product
        me.focusProduct();
    },

    save: function(){
        var me      = this,
            panel   = me.getView(),
            form    = panel.down('form');

        if(form.getForm().isValid()){
            var storeDetail = POS.app.getStore('purchase.AddDetail');

            var products = [];
            storeDetail.each(function(rec){
                products.push(rec.data)
            });

            // make sure there are any product to process purchase
            if (products.length != 0) {
                var values = form.getValues();

                values.products = Ext.encode(products);
                
                // safety first, sum total one more time before sending it to server ^_^
                values.total_price = this.sumTotalPrice();
                
                values.second_party_id = values.second_party;

                POS.fn.App.setLoading(true);
                var monitor = POS.fn.WebSocket.monitor(
                    Ext.ws.Main.on('purchase/create', function(websocket, result){
                        clearTimeout(monitor);
                        POS.fn.App.setLoading(false);
                        if (result.success){
                            me.close();
                            
                            POS.app.getStore('Purchase').load();
                        }else{
                            POS.fn.App.notification('Ups', result.errmsg);
                        }
                    }, this, {
                        single: true,
                        destroyable: true
                    })
                );
                Ext.ws.Main.send('purchase/create', values);
            } else {
                POS.fn.App.notification('Ups', ERROR_1);
            }
        }
    },

    saveAddDetail: function(){
        var panel = this.getView(),
            form = this.lookupReference('formAddDetail');

        if(
            form.getForm().isValid()
            &&
            this.lookupReference('sub_total_price').getSubmitValue() != 0
        ){
            var values  = form.getValues(),
                stock   = this.lookupReference('stock').getSelectedRecord();
            
            values.stock_id = values.stock;
            values.product_id = values.product;
            values.product_name = stock.get('product_name');
            values.unit_name = stock.get('unit_name');
            values.total_price = values.sub_total_price;
            values.unit_price = parseInt(values.total_price / values.amount);
            
            var store = POS.app.getStore('purchase.AddDetail'),
                rec = Ext.create('POS.model.PurchaseDetail');

            rec.set(values);
            store.add(rec);
            
            this.setTotalPrice();

            form.reset();
            
            this.focusProduct();
        }
    },
    
    setBalance: function(){
        var totalPrice  = this.lookupReference('total_price'),
            paid        = this.lookupReference('paid'),
            balance     = this.lookupReference('balance'),
            result      = paid.getSubmitValue() - totalPrice.getSubmitValue();
        
        balance.setValue(result);
        
        balance.setFieldStyle(result < 0 ? FIELD_MINUS : FIELD_PLUS);
    },
    
    setDefaultValue: function(){
        var secondParty = Ext.create('POS.model.Supplier', {
            id: 0,
            name: '-'
        });

        this.lookupReference('second_party').setValue(secondParty);
        
        this.lookupReference('total_price').setValue(0);
        this.lookupReference('paid').setValue(0);
        this.lookupReference('sub_total_price').setValue(0);
    },
    
    setTotalPrice: function(){
        var totalPrice = this.lookupReference('total_price');
        
        totalPrice.setValue(this.sumTotalPrice());

        this.setBalance();
    },

    sumTotalPrice: function(){
        return POS.app.getStore('purchase.AddDetail').sum('total_price');
    }
});
