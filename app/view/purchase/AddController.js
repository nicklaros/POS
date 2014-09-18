Ext.define('POS.view.purchase.AddController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.add-purchase',

    control: {
        '#': {
            boxready: function(panel){
                var me = this;
                
                var supplier = Ext.create('POS.model.Supplier', {
                    id: 0,
                    name: '-'
                });
                
                me.lookupReference('supplier').setValue(supplier);

                me.keyMap(panel);
            
                setTimeout(function(){
                    me.add();
                }, 10);
            },
            close: function(){
                POS.app.getStore('POS.store.PurchaseDetail').removeAll();
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
            celldblclick: function(){
                this.edit();
            }
        }
    },
    
    add: function(){
        Ext.fn.App.window('add-purchase-detail');
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
            
        Ext.Msg.confirm(
            '<i class="fa fa-exclamation-triangle glyph"></i> Hapus Data',
            '<b>Apakah Anda yakin akan menghapus data (<span style="color:red">' + smCount + ' data</span>)?</b><br>',
            function(btn){
                if (btn == 'yes'){
                    var id = [];
                    for(i=0;i<smCount;i++){
                        store.remove(sel[i]);
                    }
                    me.setTotalPrice();
                }
            }
        );
    },

    edit: function(){
        var rec = this.lookupReference('grid-purchase-detail').getSelectionModel().getSelection()[0];

        var edit = Ext.fn.App.window('add-purchase-detail');
        edit.isEdit = true;
        edit.getController().load(rec);
    },
    
    keyMap: function(panel){
        var me = this;
        
        new Ext.util.KeyMap({
            target: panel.getEl(),
            binding: [{
                key: 84, // Ctrl + T
                alt: true,
                defaultEventAction: 'preventDefault',
                fn: function(){ 
                    me.add();
                }
            },{
                key: 83, // Ctrl + S
                alt: true,
                defaultEventAction: 'preventDefault',
                fn: function(){ 
                    me.save();
                }
            }]
        });
    },

    save: function(){
        var panel   = this.getView(),
            form    = panel.down('form');

        if(form.getForm().isValid()){
            var storeDetail = POS.app.getStore('POS.store.PurchaseDetail');

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
                
                values.supplier_id = values.supplier;

                Ext.fn.App.setLoading(true);
                var monitor = Ext.fn.WebSocket.monitor(
                    Ext.ws.Main.on('purchase/create', function(websocket, result){
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
                Ext.ws.Main.send('purchase/create', values);
            } else {
                Ext.fn.App.notification('Ups', ERROR_1);
            }
        }
    },
    
    setTotalPrice: function(){
        var totalPrice = this.lookupReference('total_price');
        totalPrice.setValue(this.sumTotalPrice());
    },

    sumTotalPrice: function(){
        return POS.app.getStore('POS.store.PurchaseDetail').sum('total_price');
    }
});
