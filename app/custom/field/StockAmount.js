Ext.define('POS.custom.field.StockAmount', {
    extend: 'Ext.form.field.Number',
    alias: 'widget.field-stock-amount',

    fieldStyle: 'text-align: right;',
    minValue: 0,
    step: 10,
    value: 0
});