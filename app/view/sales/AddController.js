Ext.define('POS.view.sales.AddController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.add-sales',

    init: function() {
        this.listen({
            store: {
                '#sales.AddDetail': {
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
                
                this.focusStock();
            },
            show: function(){
                var stock = this.focusStock();
                
                // if record on combo stock is gone then reset form add detail
                if ( Ext.isEmpty(stock.getSelectedRecord()) ) {
                    this.lookupReference('formAddDetail').reset();
                }
            },
            hide: function(panel){
                var me = this;
                
                setTimeout(function(){
                    if ( Ext.isEmpty(Ext.main.AppTab.down('add-sales')) ) {
                        // reset form
                        me.lookupReference('formPayment').reset();
                        me.lookupReference('formAddDetail').reset();
                        
                        // set default value
                        me.setDefaultValue();

                        // clear sales detail store
                        POS.app.getStore('sales.AddDetail').removeAll();
                    }
                }, 10);
            }
        },
        'grid-sales-detail': {
            selectionchange: function(sm, selected){
                var btnEdit     = this.lookupReference('edit'),
                    btnDelete   = this.lookupReference('delete');

                btnEdit.setDisabled(selected.length !== 1);
                btnDelete.setDisabled(selected.length === 0);
            },
            celldblclick: 'edit',
            itemkeydown : function(view, record, item, index, key) {
                if (key.getKey() == 46) { //the delete key
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
        this.lookupReference('stock').focus(true);
    },

    addSecondParty: function(){
        var panel = POS.fn.App.window('add-second-party');

        panel.bindCombo = this.lookupReference('second_party').getId();
    },

    close: function(){
        Ext.main.AppTab.remove('add-sales');
    },
    
    focusStock: function(){
        var stock = this.lookupReference('stock');

        setTimeout(function(){
            stock.focus();
        }, 10);
        
        return stock;
    },

    edit: function(){
        var rec = this.lookupReference('grid-sales-detail').getSelectionModel().getSelection()[0];

        var edit = POS.fn.App.window('add-sales-detail');
        edit.getController().load(rec);
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
    
    onAmountSpecialKey: function(field, e){
        if(e.getKey() == e.ENTER) {
            this.saveAddDetail();
        }
    },
    
    onStockSelect: function(combo, record){
        // get selected record data
        var record = (Ext.isArray(record) ? record[0].getData() : record.getData());
        
        // delete selected record id so it will not conflict with id of currently edited sales record
        // when we spit it out to form
        delete record.id;
        
        // focus on amount
        this.lookupReference('amount').focus(true);
        
        // set unit name based on selected record
        this.lookupReference('unit').setHtml(record.unit_name);
    },
    
    onStockBlur: function(combo){
        if ( Ext.isEmpty(combo.getSelectedRecord()) ) combo.reset();
    },
    
    onTypeSelect: function(){
        this.lookupReference('stock').focus();
    },
    
    refreshGrid: function(){
        var grid = this.lookupReference('grid-sales-detail');
        
        grid.getView().refresh();
    },
    
    remove: function(){
        var me      = this,
            grid    = me.lookupReference('grid-sales-detail'),
            store   = grid.getStore(),
            sm      = grid.getSelectionModel(),
            sel     = sm.getSelection(),
            smCount = sm.getCount();
            
        // remove selected record
        store.remove(sel[0]);

        // update total price
        me.setTotalPrice();
        
        // focus on combo stock
        me.lookupReference('stock').focus(true);
    },

    save: function(){
        var me      = this,
            panel   = me.getView(),
            form    = panel.down('form');

        if(form.getForm().isValid()){
            var storeDetail = POS.app.getStore('sales.AddDetail');

            var products = [];
            storeDetail.each(function(rec){
                products.push(rec.data)
            });

            // make sure there are any product to process sales
            if (products.length != 0) {
                var values = form.getValues();
                
                values.second_party_id = values.second_party;

                values.products = Ext.encode(products);

                POS.fn.App.setLoading(true);
                Ext.ws.Main.send('sales/create', values);
                var monitor = POS.fn.WebSocket.monitor(
                    Ext.ws.Main.on('sales/create', function(websocket, data){
                        clearTimeout(monitor);
                        POS.fn.App.setLoading(false);
                        if (data.success){
                            me.close();
                            POS.app.getStore('Sales').load();

                            setTimeout(function(){
                                Ext.Msg.confirm(
                                    '<i class="fa fa-exclamation-triangle glyph"></i> Print',
                                    'Print Nota Penjualan?',
                                    function(btn){
                                        if (btn == 'yes'){
                                            POS.fn.App.printNotaSales(data.id);
                                        }
                                    }
                                );
                            }, 10);
                        }else{
                            POS.fn.App.notification('Ups', data.errmsg);
                        }
                    }, this, {
                        single: true,
                        destroyable: true
                    })
                );
            } else {
                POS.fn.App.notification('Ups', ERROR_1);
            }
        }
    },

    saveAddDetail: function(stock){
        var panel   = this.getView(),
            form    = this.lookupReference('formAddDetail');

        if(form.getForm().isValid()){
            var type    = this.lookupReference('type'),
                stock   = this.lookupReference('stock'),
                amount  = this.lookupReference('amount'),
                values  = stock.getSelectedRecord().getData();
            
            values.type = type.getValue();
            values.amount = amount.getValue();
                            
            switch(values.type){
                case 'Public':
                    values.unit_price = values.sell_public;
                    break;
                case 'Distributor':
                    values.unit_price = values.sell_distributor;
                    break;
                case 'Misc':
                    values.unit_price = values.sell_misc;
                    break;
            }
            
            values.unit_name = values.unit_name;
            values.total_buy_price = values.amount * values.buy;
            values.total_price_wo_discount = values.amount * values.unit_price;
            values.total_price = values.total_price_wo_discount - (values.total_price_wo_discount * values.discount / 100);
            
            var store = POS.app.getStore('sales.AddDetail'),
                rec = Ext.create('POS.model.SalesDetail', values);

            store.add(rec);
            
            this.setTotalPrice();

            form.reset();
        
            // reset unit name
            this.lookupReference('unit').setHtml('Unit');
            
            type.setValue(values.type);
            
            stock.focus(true);
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
        var customer = Ext.create('POS.model.Customer', {
            id: 0,
            name: '-'
        });

        this.lookupReference('second_party').setValue(customer);

        var cashier = Ext.create('POS.model.Cashier', {
            id: Ext.main.ViewModel.data.current_user.id,
            name: Ext.main.ViewModel.data.current_user.name
        });

        this.lookupReference('cashier').setValue(cashier); 
        
        this.lookupReference('total_price').setValue(0);
        this.lookupReference('paid').setValue(0);
    },
    
    setTotalPrice: function(){
        var totalPrice = this.lookupReference('total_price');
        totalPrice.setValue(this.sumTotalPrice());

        var buyPrice = this.lookupReference('buy_price');
        buyPrice.setValue(this.sumBuyPrice());

        this.setBalance();
    },

    sumBuyPrice: function(){
        return POS.app.getStore('sales.AddDetail').sum('total_buy_price');
    },

    sumTotalPrice: function(){
        return POS.app.getStore('sales.AddDetail').sum('total_price');
    }
});
