Ext.define('Ext.fn.Render', {
    singleton: true,

    currency: function(value){
        value = parseInt(value);
        
        return (value == 0 ? '-' : Ext.util.Format.currency(value, ' Rp ', '.'));
    },
    
    date: function(value, withDay){
        var format = (withDay ? 'l, d F Y' : 'd F Y');
        
        return Ext.util.Format.date(value, format);
    },

    discount: function(value){
        return value + ' %';
    }
});