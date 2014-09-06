Ext.define('POS.view.sales.EditDetailController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.edit-sales-detail',

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
    
    productSelect: function(combo, record){
        this.getView().getViewModel().setData(record[0].getData());
        combo.next('field').focus();
    },

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values = form.getValues(),
                model = this.getView().getViewModel();
                
            delete model.data.id;
            
            switch(values.type){
                case 'Public':
                    values.unit_price = values.stock_sell_public;
                    break;
                case 'Distributor':
                    values.unit_price = values.stock_sell_distributor;
                    break;
                case 'Misc':
                    values.unit_price = values.stock_sell_misc;
                    break;
            }
            
            values.stock_id = values.stock;
            values.total_price_wo_discount = values.amount * values.unit_price;
            values.total_price = values.total_price_wo_discount - (values.total_price_wo_discount * values.stock_discount / 100);
            
            model.setData(values);
            
            var store = POS.app.getStore('POS.store.SalesDetail'),
                rec = Ext.create('POS.model.SalesDetail');

            rec.set(model.getData());
            store.edit(rec);

            panel.close();
        }
    }
});
