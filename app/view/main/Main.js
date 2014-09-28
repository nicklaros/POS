/**
 * This class is the main view for the application. It is specified in app.js as the
 * "autoCreateViewport" property. That setting automatically applies the "viewport"
 * plugin to promote that instance of this class to the body element.
 *
 * TODO - Replace this content of this view to suite the needs of your application.
 */
Ext.define('POS.view.main.Main', {
    extend: 'Ext.container.Container',
    alias: 'widget.app-main',
    controller: 'main',
    viewModel: {
        type: 'main'
    },

    requires: [
        'POS.view.form.Login',
        'POS.view.main.Home',
        'POS.view.main.Navigation',
        'POS.view.main.Tab'
    ],

    layout: {
        type: 'border'
    },

    style: {
        'background-color':'#789'
    },

    items: [{
        region: 'west',
        xtype: 'app-nav',
        dockedItems: [{
            xtype: 'toolbar',
            hidden: true,
            dock: 'top',
            style: {
                'background': '#789'
            },
            items: [{
                text: '<i class="fa fa-bell-o glyph"></i> 0 Pemberitahuan',
                bind: {
                    text: '<i class="fa fa-bell-o glyph"></i> {notificationCount} Pemberitahuan'
                },
                handler: 'openNotification'
            }],
            bind: {
                visible: '{state}'
            }
        }]
    },{
        region: 'center',
        xtype: 'app-tab'
    }]
    
});
