Ext.define('POS.custom.field.StockAmount', {
    extend: 'Ext.form.field.Number',
    alias: 'widget.field-stock-amount',

    fieldStyle: 'text-align: right;',
    step: 10,
    value: 0
});