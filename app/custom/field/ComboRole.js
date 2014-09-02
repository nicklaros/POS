Ext.define('POS.custom.field.ComboRole', {
    extend: 'Ext.form.field.ComboBox',
    alias: 'widget.combo-role',

    requires: [
        'POS.store.combo.Role'
    ],

    displayField: 'role',
    valueField: 'id',

    editable: false,
    forceSelection: true,
    queryMode: 'local',
    triggerAction: 'all',

    initComponent: function(){
        this.store = POS.app.getStore('POS.store.combo.Role');

        this.callParent(arguments);
    }
});