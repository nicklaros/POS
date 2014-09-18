Ext.define('POS.custom.field.Address', {
    extend: 'Ext.form.field.Text',
    alias: 'widget.field-address',

    maxLength: 128,
    maskRe: MASK_RE_0
});