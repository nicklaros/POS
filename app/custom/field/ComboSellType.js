Ext.define('POS.custom.field.ComboSellType', {
    extend: 'Ext.ux.form.field.ClearCombo',
    alias: 'widget.combo-sell-type',

    requires: [
        'POS.store.combo.SellType'
    ],

    displayField: 'type',
    valueField: 'id',

    editable: false,
    forceSelection: true,
    queryMode: 'local',
    triggerAction: 'all',

    initComponent: function(){
        this.store = POS.app.getStore('POS.store.combo.SellType');

        this.callParent(arguments);
    }
});