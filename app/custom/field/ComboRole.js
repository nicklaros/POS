Ext.define('POS.custom.field.ComboRole', {
    extend: 'Ext.ux.form.field.ClearCombo',
    alias: 'widget.combo-role',

    requires: [
        'POS.store.combo.Role'
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
        this.store = POS.app.getStore('combo.Role');

        this.callParent(arguments);
    }
});