Ext.define('Ext.fn.Render', {
    singleton: true,

    currency: function(value){
        value = parseInt(value);
        return (value == 0 ? '-' : Ext.util.Format.currency(value, ' Rp ', '.'));
    },
    
    date: function(value){
        return Ext.util.Format.date(value, 'd F Y');
    },

    discount: function(value){
        return value + ' %';
    }
});