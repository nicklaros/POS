Ext.define('POS.view.main.Home' ,{
    extend: 'Ext.panel.Panel',
    alias : 'widget.home',

    requires: [
        'POS.custom.chart.transaction.Last30Days',
        'POS.view.form.Login',
        'POS.tpl.AppHeader',
        'POS.tpl.ContactDeveloper'
    ],
	
	autoScroll: true,
    waitMsgTarget: true,
    layout: 'anchor',
    bodyStyle: {
        'background-color': '#e9eaed',
        border: '0 !important',
        padding: '25px 0'
    },

    initComponent: function(){
        this.title = '<i class="fa fa-dashboard glyph"></i> Halaman Depan';

        this.items = [{
            xtype: 'container',
            layout: 'vbox',
            width: 800,
            style: {
                margin: '0 auto'
            },
            items: [{
                xtype: 'container',
                bind: {
                    data: '{info}'
                },
                tpl: Ext.create('POS.tpl.AppHeader'),
                margin: '0 0 25 0',
                width: 800
            },{
                xtype: 'container',
                itemId: 'login-n-banner',
                layout: 'hbox',
                margin: '0 0 25 0',
                bind: {
                    visible: '{!state}'
                },
                items: [{
                    xtype: 'container',
                    cls: 'panel',
                    width: 210,
                    items: [{
                        xtype: 'container',
                        html: 'Masuk',
                        cls: 'panel-header'
                    },{
                        xtype: 'login',
                        reference: 'login',
                        width: 208
                    }]
                },{
                    xtype: 'container',
                    cls: 'panel',
                    margin: '0 0 0 20',
                    padding: 3,
                    width: 570,
                    height: 249,
                    html: '<img src="resources/images/image_700x300.fw.png" style="width: 562px; height: 241px; border-radius: 2px;" />'
                }]
            },{
                xtype: 'container',
                margin: '0 0 25 0',
                width: 800,
                bind: {
                    visible: '{state}'
                },
                items:[{
                    xtype: 'chart-transaction-last30days'
                }]
            },{
                xtype: 'container',
                cls: 'panel',
                margin: '0 0 0 0',
                width: 800,
                items: [{
                    xtype: 'container',
                    html: 'Tentang Kami',
                    cls: 'panel-header'
                },{
                    xtype: 'container',
                    cls: 'panel-body',
                    style: {
                        'line-height': '1.5'
                    },
                    bind: {
                        data: '{info}'
                    },
                    tpl: Ext.create('POS.tpl.ContactDeveloper')
                }]
            }]
        }];

        this.callParent(arguments);
    }
});