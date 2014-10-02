Ext.define("POS.view.main.Tab", {
    extend: 'Ext.tab.Panel',
    alias: 'widget.app-tab',

    margins: '0 0 0 0',
    border: 0,
    bodyStyle: {
        border: '0 !important'
    },
    activeTab: 0,
    autoDestroy: false,
    minTabWidth: 100,
    maxTabWidth: 200,
    items: [{
        xtype: 'home'
    }]
});