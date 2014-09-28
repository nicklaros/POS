Ext.define('POS.custom.field.ComboProduct', {
    extend: 'Ext.ux.form.field.ClearCombo',
    alias: 'widget.combo-product',

    requires: [
        'POS.store.combo.Product',
        'POS.tpl.combo.Product'
    ],

    displayField: 'name',
    valueField: 'id',

    anyMatch: true,
    autoSelect: true,
    enableKeyEvents: true,
    forceSelection: true,
    hideTrigger: true,
    matchFieldWidth: true,
    minChars: 1,
    queryDelay: 50,
    queryMode: 'remote',
    selectOnFocus: true,
    triggerAction: 'query',
    typeAhead: true,
    typeAheadDelay: 250,
    listeners: {
        keydown: function(field){
            if (Ext.isEmpty(field.getRawValue())) {
                field.reset();
            }
        }
    },

    initComponent: function(){
        this.store = POS.app.getStore('combo.Product');

        this.listConfig = {
            itemTpl: Ext.create('POS.tpl.combo.Product')
        };

        this.callParent(arguments);
    }
});