Ext.define('POS.view.main.Home' ,{
    extend: 'Ext.panel.Panel',
    alias : 'widget.home',

    requires: [
        'POS.custom.chart.transaction.Transaction',
        'POS.custom.panel.hint.Dashboard',
        'POS.store.chart.transaction.Last30Days',
        'POS.tpl.AppHeader',
        'POS.tpl.ContactDeveloper',
        'POS.view.form.Login'
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
                itemId: 'app-header',
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
                    html: '<img src="resources/images/image_700x300.fw.png" style="width: 562px; height: 241px; border-radius: 2px;" />',
                    bind: {
                        html: '<img src="resources/images/{info.app_photo}" style="width: 562px; height: 241px; border-radius: 2px;" />'
                    }
                }]
            },{
                xtype: 'container',
                hidden: true,
                margin: '0 0 25 0',
                width: 800,
                bind: {
                    visible: '{state}'
                },
                items:[{
                    xtype: 'dashboard-hint',
                    bind: {
                        data: '{shortcutKeys}'
                    },
                    margin: '0 0 20 0',
                    width: 800
                },{
                    xtype: 'chart-transaction',
                    width: 800
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