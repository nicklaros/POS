Ext.define('POS.view.stock.AddVariant' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.add-stock-variant',
    id: 'add-stock-variant',
    controller: 'add-stock-variant',

    requires: [
        'POS.custom.field.ComboUnit',
        'POS.view.stock.AddVariantController'
    ],

	autoScroll: false,
    autoShow: true,
    bodyStyle: {
        border: '0 !important',
        padding: '25px'
    },
    constrain: true,
    layout: 'anchor',
    maximized: false,
    modal: false,
    resizable: false,
    
    bindTo: null,
    
    width: 400,

    initComponent: function(){
        this.title = '<i class="fa fa-tasks glyph"></i> Tambah Variant ';

        this.items = [{
            xtype: 'form',
            reference: 'form',
            layout: 'hbox',
            monitorValid: true,
            anchor: '100%',
            items: [{
                xtype: 'combo-unit',
                fieldLabel: 'Satuan Variant',
                name: 'unit',
                reference: 'unit',
                afterLabelTextTpl: REQUIRED,
                allowBlank: false,
                saveOnEnter: true,
                width: 150
            },{
                xtype: 'button',
                text: 'Ok',
                reference: 'ok',
                handler: 'save',
                margin: '25 0 0 10'
            },{
                xtype: 'hidden',
                name: 'product_id'
            }]
        }];

        this.callParent(arguments);
    }
});;