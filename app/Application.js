/**
 * The main application class. An instance of this class is created by app.js when it calls
 * Ext.application(). This is the ideal place to handle application launch and initialization
 * details.
 */

Ext.Loader.setPath('Ext.fn', 'app/fn');
Ext.Loader.setPath('Ext.tpl', 'app/tpl');
Ext.Loader.setPath('Overrides', 'overrides');

Ext.define('POS.Application', {
    extend: 'Ext.app.Application',
    name: 'POS',

    requires: [
        'Ext.chart.axis.Numeric',
        'Ext.chart.axis.Category',
        'Ext.chart.series.Line',
        'Ext.chart.series.Pie',
        'Ext.chart.CartesianChart',
        'Ext.chart.interactions.ItemHighlight',
        'Ext.chart.interactions.ItemInfo',
        'Ext.data.proxy.Direct',
        'Ext.direct.*',
        'Ext.fn.App',
        'Ext.fn.WebSocket',
        'Ext.form.*',
        'Ext.ux.data.proxy.WebSocket',
        'Ext.ux.WebSocket',
        'Ext.ux.WebSocketManager',
        'Ext.ux.window.Notification',
        'Overrides.view.BoundListKeyNav'
    ],

    views: [
        'credit.List',
        'currentuser.ChangePassword',
        'currentuser.UpdateBiodata',
        'customer.List',
        'debit.List',
        'DeveloperInfo',
        'notification.List',
        'option.Option',
        'product.List',
        'purchase.List',
        'report.Custom',
        'report.Monthly',
        'sales.List',
        'stock.List',
        'supplier.List',
        'unit.List',
        'user.List'
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