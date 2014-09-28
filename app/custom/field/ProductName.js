Ext.define('POS.custom.field.ProductName', {
    extend: 'Ext.form.field.Text',
    alias: 'widget.field-product-name',

    afterLabelTextTpl: REQUIRED,
    allowBlank: false,
    maxLength: 64,
    
    initComponent: function(){
        this.maskRe = MASK_RE_0;
        
        this.callParent(arguments);
    },
    
    listeners: {
        blur: function(field){
            field.setValue(Ext.util.Format.uppercase(field.getValue()));
        }
    }
});