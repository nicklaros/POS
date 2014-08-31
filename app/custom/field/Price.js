Ext.define('POS.custom.field.Price', {
    extend: 'Ext.ux.form.field.Numeric',
    alias: 'widget.field-price',

    currencySymbol: 'Rp',
    thousandSeparator: '.',

    minValue: 0,
    step: 1000,
    value: 0
});