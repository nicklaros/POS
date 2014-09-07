Ext.define('POS.view.sales.AddDetailController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.add-sales-detail',

    control: {
        '#': {
            boxready: function(){
                var stock = this.lookupReference('stock');
                setTimeout(function(){
                    stock.focus();
                }, 10);
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

    close: function(){
        this.getView().close();
    },

    load: function(record){
        var panel = this.getView(),
            form = panel.down('form');

        var stock = new POS.model.Stock;
        stock.set('id', record.get('stock_id'));
        stock.set('product_name', record.get('product_name'));
        record.set('stock', stock);
        
        form.getForm().setValues(record.getData());
    },
    
    productSelect: function(combo, record){
        this.lookupReference('form').getForm().setValues(record[0].getData());
        combo.next('field').focus();
    },

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values = form.getValues();
                            
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
            values.total_price_wo_discount = values.amount * values.unit_price;
            values.total_price = values.total_price_wo_discount - (values.total_price_wo_discount * values.discount / 100);
            
            if (!panel.isEdit) {            
                var store = POS.app.getStore('POS.store.SalesDetail'),
                    rec = Ext.create('POS.model.SalesDetail');
                    
                rec.set(values);            
                store.add(rec);
            }else{
                var rec = Ext.ComponentQuery.query('grid-sales-detail')[0].getSelectionModel().getSelection()[0];
                rec.set(values);
            }

            panel.close();
            
            Ext.ComponentQuery.query('add-sales')[0].getController().setTotalPrice();
        }
    }
});
