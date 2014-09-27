Ext.define('POS.custom.field.ComboSecondParty', {
    extend: 'Ext.ux.form.field.ClearCombo',
    alias: 'widget.combo-second-party',

    requires: [
        'POS.store.combo.SecondParty',
        'POS.tpl.combo.SecondParty'
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
        this.store = POS.app.getStore('combo.SecondParty');

        this.listConfig = {
            itemTpl: Ext.create('POS.tpl.combo.SecondParty')
        };

        this.callParent(arguments);
    }
});