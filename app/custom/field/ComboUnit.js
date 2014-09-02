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
        this.store = POS.app.getStore('POS.store.combo.Unit');

        this.callParent(arguments);
    }
});