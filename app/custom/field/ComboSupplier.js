Ext.define('POS.custom.field.ComboSupplier', {
    extend: 'Ext.ux.form.field.ClearCombo',
    alias: 'widget.combo-supplier',

    requires: [
        'POS.store.combo.Supplier'
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
        this.store = POS.app.getStore('POS.store.combo.Supplier');

        this.callParent(arguments);
    }
});