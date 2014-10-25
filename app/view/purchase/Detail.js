Ext.define('POS.view.purchase.Detail' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.detail-purchase',
    id: 'detail-purchase',
    controller: 'detail-purchase',

    requires: [
        'POS.custom.grid.PurchaseDetail',
        'POS.store.PurchaseDetail',
        'POS.tpl.PurchaseDetail',
        'POS.view.purchase.DetailController'
    ],

    layout: 'anchor',
	autoScroll: true,
    autoShow: false,
    bodyStyle: {
        'background-color': '#e9eaed',
        border: '0 !important'
    },
    cls: 'window',
    header: false,
    modal: true,
    resizable: false,
    
    padding: 0,
    width: 950,

    initComponent: function(){
        this.dockedItems = [{
            xtype: 'container',
            dock: 'top',
            layout: 'hbox',
            cls: 'panel-header window-header',
            style: {
                'border-bottom-width': '1px !important'
            },
            anchor: '100%',
            items: [{
                xtype: 'container',
                html: 'Detail Pembelian',
                flex: 1
            },{
                xtype: 'button',
                text: 'x',
                handler: 'close'
            }]
        }];
        
        this.items = [{
            xtype: 'container',
            layout: 'anchor',
            style: {
                margin: '20px auto'
            },
            width: 900,
            items:[{
                xtype: 'container',
                reference: 'detail-panel',
                cls: 'panel',
                tpl: Ext.create('POS.tpl.PurchaseDetail'),
                margin: '0 0 10 0',
                padding: 10,
                anchor: '100%',
                minHeight: 100
            },{
                xtype: 'container',
                cls: 'panel',
                anchor: '100%',
                items: [{
                    xtype: 'container',
                    html: 'Produk yang Dibeli',
                    cls: 'panel-header'
                },{
                    xtype: 'grid-purchase-detail',
                    store: POS.app.getStore('PurchaseDetail'),
                    selType: 'rowmodel',
                    withRowNumber: true
                }]
            }]
        }];

        this.maxHeight = Ext.getBody().getViewSize().height;

        this.callParent(arguments);
    }
});