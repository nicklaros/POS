Ext.define('POS.custom.field.ComboCashier', {
    extend: 'Ext.ux.form.field.ClearCombo',
    alias: 'widget.combo-cashier',

    requires: [
        'POS.store.combo.Cashier'
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

    initComponent: function(){
        this.store = POS.app.getStore('combo.Cashier');

        this.callParent(arguments);
    }
});