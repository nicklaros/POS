Ext.define('POS.custom.field.Name', {
    extend: 'Ext.form.field.Text',
    alias: 'widget.field-name',

    afterLabelTextTpl: REQUIRED,
    allowBlank: false,
    maxLength: 128,
    maskRe: MASK_RE_0
});