Ext.define('POS.view.sales.EditController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.edit-sales',

    init: function() {
        this.listen({
            store: {
                '#sales.EditDetail': {
                    add: 'refreshGrid',
                    remove: 'refreshGrid'
                }
            }
        });
    },

    control: {
        '#': {
            boxready: function(panel){
                this.keyMap(panel);
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
                    if ( Ext.isEmpty(Ext.main.AppTab.down('edit-sales')) ) {
                        // reset form
                        me.lookupReference('formPayment').reset();
                        me.lookupReference('formAddDetail').reset();
                        
                        // set default value
                        me.setDefaultValue(panel);

                        // clear sales detail store
                        POS.app.getStore('sales.EditDetail').removeAll();
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
        this.focusStock();
    },

    addSecondParty: function(){
        var panel = POS.fn.App.window('add-second-party');

        panel.bindCombo = this.lookupReference('second_party').getId();
    },

    close: function(){
        Ext.main.AppTab.remove('edit-sales');
    },

    edit: function(){
        var rec = this.lookupReference('grid-sales-detail').getSelectionModel().getSelection()[0];

        var edit = POS.fn.App.window('edit-sales-detail');
        edit.getController().load(rec);
    },
    
    focusStock: function(){
        var stock = this.lookupReference('stock');
                
        setTimeout(function(){
            stock.focus(true);
        }, 10);
        
        return stock;
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

    load: function(params){
        var panel = this.getView(),
            form = panel.down('form');

        POS.fn.App.setLoading(true);
        Ext.ws.Main.send('sales/loadFormEdit', params);
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('sales/loadFormEdit', function(websocket, result){
                clearTimeout(monitor);
                POS.fn.App.setLoading(false);
                if (result.success){
                    var secondParty = Ext.create('POS.model.SecondParty', {
                        id  : result.data.second_party_id,
                        name: result.data.second_party_name
                    });

                    result.data.second_party = secondParty;

                    var cashier = Ext.create('POS.model.Cashier', {
                        id  : result.data.cashier_id,
                        name: result.data.cashier_name
                    });

                    result.data.cashier_id = cashier;

                    form.getForm().setValues(result.data);

                    POS.app.getStore('sales.EditDetail').loadData(result.detail);
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
        me.focusStock();
    },

    save: function(){
        var me      = this,
            panel   = me.getView(),
            form    = panel.down('form');

        if(form.getForm().isValid()){
            var storeDetail = POS.app.getStore('sales.EditDetail');

            var products = [];
            storeDetail.each(function(rec){
                products.push(rec.data);
            });

            // get removed product from sales
            var removed_id = [];
            storeDetail.removed.forEach(function(rec){
                removed_id.push(rec.id);
            });

            // make sure there are any product to process sales
            if (products.length != 0) {
                var values = form.getValues();
                
                values.second_party_id = values.second_party;

                values.products = Ext.encode(products);
                values.removed_id = removed_id;

                POS.fn.App.setLoading(true);
                Ext.ws.Main.send('sales/update', values);
                var monitor = POS.fn.WebSocket.monitor(
                    Ext.ws.Main.on('sales/update', function(websocket, data){
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
            
            var store = POS.app.getStore('sales.EditDetail'),
                rec = Ext.create('POS.model.SalesDetail', values);

            store.add(rec);
            
            this.setTotalPrice();

            form.reset();
            
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
    
    setDefaultValue: function(panel){
        var customer = Ext.create('POS.model.Customer', {
            id: 0,
            name: '-'
        });

        panel.lookupReference('second_party').setValue(customer);

        var cashier = Ext.create('POS.model.Cashier', {
            id: Ext.main.ViewModel.data.current_user.id,
            name: Ext.main.ViewModel.data.current_user.name
        });

        panel.lookupReference('cashier').setValue(cashier); 
        
        this.lookupReference('total_price').setValue(0);
        this.lookupReference('paid').setValue(0);
    },

    setTotalPrice: function(){
        var totalPrice = this.lookupReference('total_price');
        totalPrice.setValue(this.sumTotalPrice());

        var buyPrice = this.lookupReference('buy_price');
        buyPrice.setValue(this.sumBuyPrice());

        this.setBalance()
    },

    sumBuyPrice: function(){
        return POS.app.getStore('sales.EditDetail').sum('total_buy_price');
    },

    sumTotalPrice: function(){
        return POS.app.getStore('sales.EditDetail').sum('total_price');
    }
});
