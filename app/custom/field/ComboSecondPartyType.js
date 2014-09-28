Ext.define('POS.custom.field.ComboSecondPartyType', {
    extend: 'Ext.ux.form.field.ClearCombo',
    alias: 'widget.combo-second-party-type',

    requires: [
        'POS.store.combo.SecondPartyType'
    ],

    displayField: 'name',
    valueField: 'value',

    editable: false,
    forceSelection: true,
    queryMode: 'local',
    triggerAction: 'all',

    initComponent: function(){
        this.store = POS.app.getStore('combo.SecondPartyType');

        this.callParent(arguments);
    }
});