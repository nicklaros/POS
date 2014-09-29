Ext.define('POS.view.sales.EditDetailController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.edit-sales-detail',

    control: {
        '#': {
            boxready: function(panel){
                var stock = this.lookupReference('stock');
                
                setTimeout(function(){
                    stock.focus();
                }, 10);
            }
        },
        'textfield[amountOnEnter = true]': {
            specialkey: function(field, e){
                if(e.getKey() == e.ENTER) {
                    this.lookupReference('amount').focus(true);
                }
            }
        },
        'textfield[tabOnEnter = true]': {
            specialkey: function(field, e){
                if(e.getKey() == e.ENTER) {
                    setTimeout(function(){
                        field.next('field').focus();
                    }, 10);
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

    close: function(){
        this.getView().close();
    },

    load: function(record){
        var panel = this.getView(),
            form = panel.down('form');

        // create stock model from edited sales detail record
        var stock = Ext.create('POS.model.Stock', record.getData());
        
        // set id of previously created stock model to stock_id
        // why? because actually that id before was the id of sales detail, not stock! 
        stock.set('id', record.get('stock_id'));

        // put created stock model to currently edited record
        record.set('stock', stock);
        
        // errrmm
        form.getForm().setValues(record.getData());
        
        var comboStock = this.lookupReference('stock');

        // add edited stock to comboStock's store
        comboStock.getStore().add(stock);
        
        // make sure stock is selected 
        comboStock.select(stock);
        
        this.lookupReference('unit').setHtml(stock.get('unit_name'));
        
        var amount = this.lookupReference('amount');        
        setTimeout(function(){
            amount.focus();
        }, 10);
    },
    
    productSelect: function(combo, record){
        // get selected record data
        var record = (Ext.isArray(record) ? record[0].getData() : record.getData());
        
        // delete selected record id so it will not conflict with id of currently edited sales detail record
        // when we spit it out to form
        delete record.id;
        
        this.lookupReference('form').getForm().setValues(record);
        
        this.lookupReference('unit').setHtml(record.unit_name);
        
        this.lookupReference('amount').setValue(1);
        this.lookupReference('amount').focus(true);
    },

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values  = form.getValues(),
                stock   = this.lookupReference('stock').getSelectedRecord();
                            
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
            
            values.stock_id = values.stock;
            values.unit_name = stock.get('unit_name');
            values.total_buy_price = values.amount * values.buy;
            values.total_price_wo_discount = values.amount * values.unit_price;
            values.total_price = values.total_price_wo_discount - (values.total_price_wo_discount * values.discount / 100);
            
            if (!panel.isEdit) {
                delete values.id;
                
                var store = POS.app.getStore('SalesDetail'),
                    rec = Ext.create('POS.model.SalesDetail', values);
                    
                store.add(rec);
            }else{
                var rec = Ext.ComponentQuery.query('grid-sales-detail')[0].getSelectionModel().getSelection()[0];
                
                rec.set(values);
            }
            
            panel.isEdit = false;
            
            var editSales = Ext.ComponentQuery.query('edit-sales')[0];
            
            editSales.getController().setTotalPrice();
            editSales.type = values.type;

            form.reset();
            
            this.lookupReference('status').setHtml(values.amount + ' ' + values.unit_name + ' <span class="green">' + values.product_name + '</span> harga <span class="green">' + Ext.fn.Render.sellType(values.type) + '</span> sebesar <span class="green">' + Ext.fn.Render.plainCurrency(values.unit_price) + '</span> per ' + values.unit_name + ' telah ditambahkan.');
            
            this.lookupReference('type').setValue(values.type);
            
            this.lookupReference('stock').focus();
        }
    }
});
