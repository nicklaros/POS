Ext.define('POS.custom.field.Phone', {
    extend: 'Ext.form.field.Text',
    alias: 'widget.field-phone',

    maxLength: 20,
    maskRe: MASK_RE_2
});