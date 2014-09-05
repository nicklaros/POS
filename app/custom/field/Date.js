Ext.define('POS.custom.field.Date' ,{
    extend: 'Ext.form.field.Date',
    alias : 'widget.field-date',

    format: 'd-m-Y',
    submitFormat: 'Y-m-d',
    altFormats: FORMAT_0,
    emptyText: 'msl: 17-08-1945'
});