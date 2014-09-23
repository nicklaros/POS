Ext.define('Ext.fn.Render', {
    singleton: true,

    amount: function(value){
        var amount = parseInt(value.amount);
        var unlimited = value.unlimited || false;
        
        return (unlimited == true ? 'tak terhingga' : amount);
    },

    amountOnGrid: function(value, meta, record){
        return (record.get('unlimited') == true ? '~' : value);
    },
    
    creditBalance: function(value){
        value = parseInt(value);
        
        return (value <= 0 ? 'Lunas' : Ext.fn.Render.plainCurrency(value));
    },

    currency: function(value, cls){
        value = parseInt(value);
        cls = (typeof(cls) == 'string' ? cls : '');
        
        return '<span class="' + cls + '">' + Ext.fn.Render.plainCurrency(value) + '</span>';
    },
    
    date: function(value, withDay){
        var format = (withDay === true ? 'l, d F Y' : 'd F Y');
        
        return Ext.util.Format.date(value, format);
    },

    discount: function(value){
        return value + ' %';
    },
    
    paymentBalance: function(value){
        value = parseInt(value);
        
        return '<span class="' + (value < 0 ? 'red' : 'green') + '">' + Ext.fn.Render.plainCurrency(value) + '</span>';
    },
    
    plainCurrency: function(value){
        value = parseInt(value);
        
        return (value == 0 ? '-' : Ext.util.Format.currency(value, ' Rp ', '.'));
    },
    
    time: function(value){
        var format = 'l, d F Y H:i:s';
        
        return Ext.util.Format.date(value, format);
    }
});