Ext.define('POS.tpl.MainNavigation', {
    extend: 'Ext.XTemplate',

    html: [
        '<tpl if="main">',
            '<div class="main-nav-container">',
            '<div class="main-nav-body">',
            '<tpl for="main">',
                '<a onClick="POS.fn.App.mn{action}()"><i class="fa fa-{icon} main-nav-icon"></i> {text}</a>',
            '</tpl>',
            '</div></div>',
        '</tpl>',
        '<tpl if="report">',
            '<div class="main-nav-container">',
            '<div class="main-nav-header">Laporan</div>',
            '<div class="main-nav-body">',
            '<tpl for="report">',
                '<a onClick="POS.fn.App.mn{action}()"><i class="fa fa-{icon} main-nav-icon"></i> {text}</a>',
            '</tpl>',
            '</div></div>',
        '</tpl>',
        '<tpl if="option">',
            '<div class="main-nav-container">',
            '<div class="main-nav-header">Pengaturan</div>',
            '<div class="main-nav-body">',
            '<tpl for="option">',
                '<a onClick="POS.fn.App.mn{action}()"><i class="fa fa-{icon} main-nav-icon"></i> {text}</a>',
            '</tpl>',
            '</div></div>',
        '</tpl>',
        '<tpl if="support">',
            '<div class="main-nav-container">',
            '<div class="main-nav-header">Support</div>',
            '<div class="main-nav-body">',
            '<tpl for="support">',
                '<a onClick="POS.fn.App.mn{action}()"><i class="fa fa-{icon} main-nav-icon"></i> {text}</a>',
            '</tpl>',
            '</div></div>',
        '</tpl>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});