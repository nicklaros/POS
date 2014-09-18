Ext.define('POS.custom.field.UnitName', {
    extend: 'Ext.form.field.Text',
    alias: 'widget.field-unit-name',

    afterLabelTextTpl: REQUIRED,
    allowBlank: false,
    maxLength: 32,
    
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