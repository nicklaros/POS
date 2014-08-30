Ext.define('Ext.fn.Render', {
    singleton: true,

    currency: function(value){
        value = parseInt(value);
        return (value == 0 ? '-' : Ext.util.Format.currency(value, ' Rp ', '.'));
    },

    diskon: function(value){
        return value + ' %';
    }
});