Ext.define('POS.custom.field.Stock', {
    extend: 'Ext.form.field.Number',
    alias: 'widget.field-stock',

    fieldStyle: 'text-align: right;',
    minValue: 0,
    step: 10,
    value: 0
});