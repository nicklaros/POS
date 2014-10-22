Ext.define('POS.view.main.Navigation' ,{
    extend: 'Ext.panel.Panel',
    alias : 'widget.app-nav',

    requires: [
        'POS.tpl.MainNavigation'
    ],

    title: 'Next POS',
    bind: {
        title: '{current_user.name}',
        data: '{menu}'
    },
    tpl: Ext.create('POS.tpl.MainNavigation'),

    autoScroll: true,
    border: 0,
    bodyStyle: {
        border: '0 !important',
        'background-color': '#789'
    },
    collapsible: true,
    margins: '0 0 0 0',
    width: 200
});