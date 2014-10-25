Ext.define('POS.custom.field.RoleName', {
    extend: 'Ext.form.field.Text',
    alias: 'widget.field-role-name',

    afterLabelTextTpl: REQUIRED,
    allowBlank: false,
    maxLength: 128,
    
    initComponent: function(){
        this.maskRe = MASK_RE_0;
        
        this.callParent(arguments);
    }
});