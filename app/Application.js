/**
 * The main application class. An instance of this class is created by app.js when it calls
 * Ext.application(). This is the ideal place to handle application launch and initialization
 * details.
 */

Ext.Loader.setPath('Ext.fn', 'app/fn');
Ext.Loader.setPath('Ext.tpl', 'app/tpl');

Ext.define('POS.Application', {
    extend: 'Ext.app.Application',
    name: 'POS',

    requires: [
        'Ext.data.proxy.Direct',
        'Ext.direct.*',
        'Ext.fn.App',
        'Ext.fn.WebSocket',
        'Ext.form.*',
        'Ext.ux.data.proxy.WebSocket',
        'Ext.ux.WebSocket',
        'Ext.ux.WebSocketManager',
        'Ext.ux.window.Notification'
    ],

    stores: [

    ],

    views: [
        'POS.view.notification.List',
        'POS.view.product.List',
        'POS.view.purchase.List',
        'POS.view.sales.List',
        'POS.view.stock.List',
        'POS.view.user.List'
    ],
    
    launch: function () {
        // Destroy init loader
        Ext.get('initLoader').destroy();

        // Register Ext.Direct Provider
        Ext.direct.Manager.addProvider(Ext.REMOTING_API);

        // Initialize application
        Ext.fn.App.init();

        // Override standart configurations
        Ext.fn.Util.overrides();
    }
});