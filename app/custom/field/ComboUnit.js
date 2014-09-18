Ext.define('POS.custom.field.ComboUnit', {
    extend: 'Ext.ux.form.field.ClearCombo',
    alias: 'widget.combo-unit',

    requires: [
        'POS.store.combo.Unit'
    ],

    displayField: 'name',
    valueField: 'id',

    anyMatch: true,
    autoSelect: true,
    enableKeyEvents: true,
    forceSelection: true,
    hideTrigger: false,
    matchFieldWidth: true,
    minChars: 1,
    queryDelay: 50,
    queryMode: 'remote',
    selectOnFocus: true,
    triggerAction: 'all',
    typeAhead: true,
    typeAheadDelay: 250,

    initComponent: function(){
        this.store = POS.app.getStore('combo.Unit');

        this.callParent(arguments);
    }
});