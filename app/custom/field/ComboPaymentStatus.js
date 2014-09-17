Ext.define('POS.custom.field.ComboPaymentStatus', {
    extend: 'Ext.ux.form.field.ClearCombo',
    alias: 'widget.combo-payment-status',

    store: [
        'Lunas',
        'Belum Lunas'
    ],

    editable: false,
    forceSelection: true,
    queryMode: 'local',
    triggerAction: 'all'
});