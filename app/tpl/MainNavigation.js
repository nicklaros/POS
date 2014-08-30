Ext.define('Ext.tpl.MainNavigation', {
    extend: 'Ext.XTemplate',

    html: [
        '<tpl if="main">',
            '<div class="main-nav-container">',
            '<div class="main-nav-header">Menu Utama</div>',
            '<div class="main-nav-body">',
            '<tpl for="main">',
                '<a onClick="Ext.fn.App.mn{action}()"><i class="fa fa-{icon} main-nav-icon"></i> {text}</a>',
            '</tpl>',
            '</div></div>',
        '</tpl>',
        '<tpl if="option">',
            '<div class="main-nav-container">',
            '<div class="main-nav-header">Pengaturan</div>',
            '<div class="main-nav-body">',
            '<tpl for="option">',
                '<a onClick="Ext.fn.App.mn{action}()"><i class="fa fa-{icon} main-nav-icon"></i> {text}</a>',
            '</tpl>',
            '</div></div>',
        '</tpl>',
        '<tpl if="support">',
            '<div class="main-nav-container">',
            '<div class="main-nav-header">Support</div>',
            '<div class="main-nav-body">',
            '<tpl for="support">',
                '<a onClick="Ext.fn.App.mn{action}()"><i class="fa fa-{icon} main-nav-icon"></i> {text}</a>',
            '</tpl>',
            '</div></div>',
        '</tpl>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});