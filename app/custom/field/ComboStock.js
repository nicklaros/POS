Ext.define('POS.custom.field.ComboStock', {
    extend: 'Ext.ux.form.field.ClearCombo',
    alias: 'widget.combo-stock',

    requires: [
        'POS.store.combo.Stock',
        'POS.tpl.combo.Stock'
    ],

    displayField: 'product_name',
    valueField: 'stock_id',

    anyMatch: true,
    autoSelect: true,
    enableKeyEvents: true,
    forceSelection: true,
    hideTrigger: true,
    matchFieldWidth: true,
    minChars: 1,
    queryDelay: 100,
    queryMode: 'remote',
    selectOnFocus: true,
    triggerAction: 'query',
    typeAhead: false,
    typeAheadDelay: 250,

    initComponent: function(){
        this.store = POS.app.getStore('combo.Stock');

        this.listConfig = {
            itemTpl: Ext.create('POS.tpl.combo.Stock')
        };

        this.callParent(arguments);
    }
});