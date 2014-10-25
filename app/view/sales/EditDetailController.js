Ext.define('POS.view.sales.EditDetailController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.edit-sales-detail',

    control: {
        '#': {
            hide: function(){
                // remove combo stock's store
                this.lookupReference('stock').getStore().removeAll();

                setTimeout(function(){
                    // focus on combo stock
                    Ext.ComponentQuery.query('edit-sales [name = stock]')[0].focus();
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
    
    onProductSelect: function(combo, record){
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
    
    onProductBlur: function(combo){
        if (Ext.isEmpty(combo.getSelectedRecord())) combo.reset();
    },
    
    onTypeSelect: function(){
        this.lookupReference('amount').focus();
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
            
            // update record
            POS.app.getStore('sales.EditDetail').getById(panel.record).set(values);
            
            // hide panel
            panel.hide();
            
            // get reference to add-sales panel and it's controller
            var editSales = Ext.ComponentQuery.query('edit-sales')[0],
                editSalesController = editSales.getController();
            
            // set total price
            editSalesController.setTotalPrice();
            
            // set sales type
            editSalesController.lookupReference('type').setValue(values.type);
            
            // focus on combo stock
            editSalesController.lookupReference('stock').focus();
            
            form.reset();
        }
    }
});
