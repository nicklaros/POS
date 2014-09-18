Ext.define('POS.custom.field.ComboGender', {
    extend: 'Ext.ux.form.field.ClearCombo',
    alias: 'widget.combo-gender',

    requires: [
        'POS.store.combo.Gender'
    ],

    displayField: 'name',
    valueField: 'value',

    editable: false,
    forceSelection: true,
    queryMode: 'local',
    triggerAction: 'all',

    initComponent: function(){
        this.store = POS.app.getStore('combo.Gender');

        this.callParent(arguments);
    }
});