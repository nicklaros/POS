Ext.define('POS.custom.field.ComboStock', {
    extend: 'Ext.ux.form.field.ClearCombo',
    alias: 'widget.combo-stock',

    requires: [
        'Ext.tpl.combo.Stock',
        'POS.store.combo.Stock'
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

    initComponent: function(){
        this.store = POS.app.getStore('POS.store.combo.Stock');

        this.listConfig = {
            itemTpl: new Ext.tpl.combo.Stock
        };

        this.callParent(arguments);
    }
});