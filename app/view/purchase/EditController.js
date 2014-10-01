Ext.define('POS.view.purchase.EditController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.edit-purchase',

    control: {
        '#': {
            boxready: function(panel){
                this.keyMap(panel);
            },
            close: function(){
                POS.app.getStore('PurchaseDetail').removeAll(true);
            }
        },
        'textfield[saveOnEnter = true]': {
            specialkey: function(field, e){
                if (e.getKey() == e.ENTER) this.save();
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
        }
    },

    add: function(){
        Ext.fn.App.window('edit-purchase-detail');
    },

    addSecondParty: function(){
        var panel = Ext.fn.App.window('add-second-party');

        panel.bindCombo = this.lookupReference('second_party').getId();
        
        panel.down('[name = type]').setValue('Supplier');
    },

    close: function(){
        this.getView().close();
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
        
        // refresh grid
        grid.getView().refresh();
    },

    edit: function(){
        var rec = this.lookupReference('grid-purchase-detail').getSelectionModel().getSelection()[0];

        var edit = Ext.fn.App.window('edit-purchase-detail');
        edit.isEdit = true;
        edit.getController().load(rec);
    },

    keyMap: function(panel){
        var me = this;
        
        new Ext.util.KeyMap({
            target: panel.getEl(),
            binding: [{
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

        Ext.fn.App.setLoading(true);
        var monitor = Ext.fn.WebSocket.monitor(
            Ext.ws.Main.on('purchase/loadFormEdit', function(websocket, result){
                clearTimeout(monitor);
                Ext.fn.App.setLoading(false);
                if (result.success){
                    var secondParty = Ext.create('POS.model.SecondParty', {
                        id  : result.data.second_party_id,
                        name: result.data.second_party_name
                    });

                    result.data.second_party = secondParty;

                    form.getForm().setValues(result.data);

                    POS.app.getStore('PurchaseDetail').loadData(result.detail);

                    var add = this.lookupReference('add');
                    setTimeout(function(){
                        add.focus();
                    }, 10);
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
        Ext.ws.Main.send('purchase/loadFormEdit', params);
    },

    save: function(){
        var panel   = this.getView(),
            form    = panel.down('form');

        if(form.getForm().isValid()){
            var storeDetail = POS.app.getStore('PurchaseDetail');

            var products = [];
            storeDetail.each(function(rec){
                products.push(rec.data)
            });

            // get removed product from purchase
            var removed_id = [];
            storeDetail.removed.forEach(function(rec){
                removed_id.push(rec.id);
            });

            // make sure there are any product to process purchase
            if (products.length != 0) {
                var values = form.getValues();

                values.products = Ext.encode(products);
                values.removed_id = removed_id;
                
                // safety first, sum total one more time before sending it to server ^_^
                values.total_price = this.sumTotalPrice();
                
                values.second_party_id = values.second_party;

                Ext.fn.App.setLoading(true);
                var monitor = Ext.fn.WebSocket.monitor(
                    Ext.ws.Main.on('purchase/update', function(websocket, result){
                        clearTimeout(monitor);
                        Ext.fn.App.setLoading(false);
                        if (result.success){
                            panel.close();
                            POS.app.getStore('Purchase').load();
                        }else{
                            Ext.fn.App.notification('Ups', result.errmsg);
                        }
                    }, this, {
                        single: true,
                        destroyable: true
                    })
                );
                Ext.ws.Main.send('purchase/update', values);
            } else {
                Ext.fn.App.notification('Ups', ERROR_1);
            }
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
    
    setTotalPrice: function(){
        var totalPrice = this.lookupReference('total_price');
        
        totalPrice.setValue(this.sumTotalPrice());

        this.setBalance();
    },

    sumTotalPrice: function(){
        return POS.app.getStore('PurchaseDetail').sum('total_price');
    }
    
});
