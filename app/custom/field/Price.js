Ext.define('POS.custom.field.Price', {
    extend: 'Ext.ux.form.field.Currency',
    alias: 'widget.field-price',

    symbol: 'Rp',
    thousandSeparator: '.',
    selectOnFocus: true
    
});