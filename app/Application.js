/**
 * The main application class. An instance of this class is created by app.js when it calls
 * Ext.application(). This is the ideal place to handle application launch and initialization
 * details.
 */

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
        'Ext.form.*',
        'Ext.layout.container.Accordion',
        'Ext.ux.data.proxy.WebSocket',
        'Ext.ux.WebSocket',
        'Ext.ux.WebSocketManager',
        'Ext.ux.window.Notification',
        'Overrides.view.BoundListKeyNav',
        'POS.fn.App',
        'POS.fn.WebSocket'
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
        'role.List',
        'sales.List',
        'stock.List',
        'supplier.List',
        'unit.List',
        'user.List'
    ],
    
    controllers: [
        'Global'
    ],
    
    launch: function () {
        // Destroy init loader
        Ext.get('initLoader').destroy();

        // Register Ext.Direct Provider
        Ext.direct.Manager.addProvider(Ext.REMOTING_API);

        // Initialize application
        POS.fn.App.init();

        // Override standart configurations
        POS.fn.Util.overrides();
    }
});