Ext.define('POS.custom.field.ComboCustomer', {
    extend: 'Ext.ux.form.field.ClearCombo',
    alias: 'widget.combo-customer',

    requires: [
        'POS.store.combo.Customer'
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
    triggerAction: 'query',
    typeAhead: true,
    typeAheadDelay: 250,

    initComponent: function(){
        this.store = POS.app.getStore('POS.store.combo.Customer');

        this.callParent(arguments);
    }
});