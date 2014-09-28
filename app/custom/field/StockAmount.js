Ext.define('POS.custom.field.StockAmount', {
    extend: 'Ext.form.field.Number',
    alias: 'widget.field-stock-amount',

    fieldStyle: 'text-align: right;',
    selectOnFocus: true,
    step: 10,
    submitLocaleSeparator: false,
    value: 0
});