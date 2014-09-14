Ext.define('POS.view.sales.EditController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.edit-sales',

    control: {
        '#': {
            boxready: function(panel){
                this.keyMap(panel);
            },
            close: function(){
                POS.app.getStore('POS.store.SalesDetail').removeAll(true);
            }
        },
        'textfield[name = paid]': {
            change: function(){
                this.setBalance();
            }
        },
        'textfield[saveOnEnter = true]': {
            specialkey: function(field, e){
                if (e.getKey() == e.ENTER) this.save();
            }
        },
        'grid-sales-detail': {
            selectionchange: function(sm, selected){
                var btnEdit     = this.lookupReference('edit'),
                    btnDelete   = this.lookupReference('delete');

                btnEdit.setDisabled(selected.length !== 1);
                btnDelete.setDisabled(selected.length === 0);
            },
            celldblclick: function(){
                this.edit();
            }
        }
    },

    add: function(){
        Ext.fn.App.window('edit-sales-detail');
    },

    close: function(){
        this.getView().close();
    },

    remove: function(){
        var grid    = this.lookupReference('grid-sales-detail'),
            store   = grid.getStore(),
            sm      = grid.getSelectionModel(),
            sel     = sm.getSelection(),
            smCount = sm.getCount();

        Ext.Msg.confirm(
            '<i class="fa fa-exclamation-triangle glyph"></i> Hapus Data',
            '<b>Apakah Anda yakin akan menghapus data (<span style="color:red">' + smCount + ' data</span>)?</b><br>',
            function(btn){
                if (btn == 'yes'){
                    var id = [];
                    for(i=0;i<smCount;i++){
                        store.remove(sel[i]);
                    }
                }
            }
        );
    },

    edit: function(){
        var rec = this.lookupReference('grid-sales-detail').getSelectionModel().getSelection()[0];

        var edit = Ext.fn.App.window('edit-sales-detail');
        edit.isEdit = true;
        edit.getController().load(rec);
    },

    keyMap: function(panel){
        var me = this;
        
        new Ext.util.KeyMap({
            target: panel.getEl(),
            binding: [{
                key: 65, // Ctrl + A
                ctrl: true,
                defaultEventAction: 'preventDefault',
                fn: function(){ 
                    me.add();
                }
            },{
                key: 83, // Ctrl + S
                ctrl: true,
                defaultEventAction: 'preventDefault',
                fn: function(){ 
                    me.lookupReference('paid').focus(true);
                }
            }]
        });
    },

    load: function(params){
        var panel = this.getView(),
            form = panel.down('form');

        Ext.fn.App.setLoading(true);
        Ext.ws.Main.send('sales/loadFormEdit', params);
        var monitor = Ext.fn.WebSocket.monitor(
            Ext.ws.Main.on('sales/loadFormEdit', function(websocket, result){
                clearTimeout(monitor);
                Ext.fn.App.setLoading(false);
                if (result.success){
                    var customer = Ext.create('POS.model.Customer', {
                        id  : result.data.customer_id,
                        name: result.data.customer_name
                    });

                    result.data.customer_id = customer;

                    var cashier = Ext.create('POS.model.Cashier', {
                        id  : result.data.cashier_id,
                        name: result.data.cashier_name
                    });

                    result.data.cashier_id = cashier;

                    form.getForm().setValues(result.data);

                    POS.app.getStore('POS.store.SalesDetail').loadData(result.detail);

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
    },

    save: function(){
        var panel   = this.getView(),
            form    = panel.down('form');

        if(form.getForm().isValid()){
            var storeDetail = POS.app.getStore('POS.store.SalesDetail');

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

                values.products = Ext.encode(products);
                values.removed_id = removed_id;

                Ext.fn.App.setLoading(true);
                Ext.ws.Main.send('sales/update', values);
                var monitor = Ext.fn.WebSocket.monitor(
                    Ext.ws.Main.on('sales/update', function(websocket, data){
                        clearTimeout(monitor);
                        Ext.fn.App.setLoading(false);
                        if (data.success){
                            panel.close();
                            POS.app.getStore('POS.store.Sales').load();

                            Ext.Msg.confirm(
                                '<i class="fa fa-exclamation-triangle glyph"></i> Print',
                                'Print Nota Penjualan?',
                                function(btn){
                                    if (btn == 'yes'){
                                        Ext.fn.App.printNotaSales(data.id);
                                    }
                                }
                            );
                        }else{
                            Ext.fn.App.notification('Ups', data.errmsg);
                        }
                    }, this, {
                        single: true,
                        destroyable: true
                    })
                );
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

        var buyPrice = this.lookupReference('buy_price');
        buyPrice.setValue(this.sumBuyPrice());

        this.setBalance()
    },

    sumBuyPrice: function(){
        return POS.app.getStore('POS.store.SalesDetail').sum('total_buy_price');
    },

    sumTotalPrice: function(){
        return POS.app.getStore('POS.store.SalesDetail').sum('total_price');
    }
});
