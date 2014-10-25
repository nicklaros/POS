Ext.define('POS.tpl.PriceStatus', {
    extend: 'Ext.XTemplate',

    html: [
        '<tpl switch="status">',
            '<tpl case="up">',
                '<span class="red"> <i class="fa fa-caret-up glyph"></i> {[ POS.fn.Render.currency(values.amount) ]} </span>',
            '<tpl case="down">',
                '<span class="green"> <i class="fa fa-caret-down glyph"></i> {[ POS.fn.Render.currency(values.amount) ]} </span>',
            '<tpl default>',
                '<span class="blue"> <i class="fa fa-caret-right glyph"></i> </span>',
        '</tpl>'
    ],

    constructor: function() {
        this.callParent(this.html);
    }
});