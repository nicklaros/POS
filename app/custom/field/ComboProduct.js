Ext.define('POS.custom.field.ComboProduct', {
    extend: 'Ext.ux.form.field.ClearCombo',
    alias: 'widget.combo-product',

    requires: [
        'Ext.tpl.combo.Product',
        'POS.store.combo.Product'
    ],

    displayField: 'name',
    valueField: 'id',

    anyMatch: true,
    autoSelect: false,
    enableKeyEvents: true,
    forceSelection: true,
    hideTrigger: true,
    matchFieldWidth: true,
    minChars: 1,
    queryDelay: 50,
    queryMode: 'remote',
    triggerAction: 'query',
    typeAhead: false,
    typeAheadDelay: 250,
    listeners: {
        keydown: function(field){
            if (Ext.isEmpty(field.getRawValue())) {
                field.reset();
            }
        }
    },

    initComponent: function(){
        this.store = POS.app.getStore('POS.store.combo.Product');

        this.listConfig = {
            itemTpl: new Ext.tpl.combo.Product
        };

        this.callParent(arguments);
    }
});