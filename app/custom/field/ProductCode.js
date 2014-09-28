Ext.define('POS.custom.field.ProductCode', {
    extend: 'Ext.form.field.Text',
    alias: 'widget.field-product-code',

    afterLabelTextTpl: REQUIRED,
    allowBlank: false,
    maxLength: 20,
    
    initComponent: function(){
        this.maskRe = MASK_RE_1;
        
        this.callParent(arguments);
    },
    
    listeners: {
        blur: function(field){
            field.setValue(Ext.util.Format.uppercase(field.getValue()));
        }
    }
});