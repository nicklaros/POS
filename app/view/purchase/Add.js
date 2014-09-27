Ext.define('POS.view.purchase.Add' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.add-purchase',
    id: 'add-purchase',
    controller: 'add-purchase',

    requires: [
        'POS.custom.field.ComboSecondParty',
        'POS.custom.field.Date',
        'POS.custom.field.Price',
        'POS.custom.grid.PurchaseDetail',
        'POS.custom.panel.hint.Purchase',
        'POS.view.purchase.AddController',
        'POS.view.purchase.AddDetail',
        'POS.view.secondparty.Add'
    ],

	autoScroll: true,
    autoShow: true,
    bodyStyle: {
        'background-color': '#e9eaed',
        border: '0 !important',
        padding: '25px'
    },
    cls: 'window',
    constrain: true,
    layout: 'anchor',
    maximized: true,
    modal: true,
    resizable: false,

    initComponent: function(){
        this.title = '<i class="fa fa-truck glyph"></i> Pembelian Baru';

        this.items = [{
            xtype: 'container',
            layout: 'vbox',
            style: {
                margin: '0 auto'
            },
            width: 900,
            items: [{
                xtype: 'purchase-hint',
                bind: {
                    data: '{shortcutKeys}'
                },
                margin: '0 0 20 0',
                width: 900
            },{
                xtype: 'form',
                bodyPadding: 10,
                cls: 'panel',
                monitorValid: true,
                margin: '0 0 10 0',
                width: 900,
                items: [{
                    xtype: 'container',
                    anchor: '100%',
                    layout: 'hbox',
                    margin: '0 0 10 0',
                    items:[{
                        xtype: 'field-date',
                        fieldLabel: 'Tanggal',
                        name: 'date',
                        afterLabelTextTpl: REQUIRED,
                        allowBlank: false,
                        value: new Date(),
                        width: 130
                    },{
                        xtype: 'combo-second-party',
                        fieldLabel: 'Dibeli Dari',
                        name: 'second_party',
                        reference: 'second_party',
                        afterLabelTextTpl: REQUIRED,
                        allowBlank: false,
                        margin: '0 0 0 20',
                        width: 200
                    },{
                        xtype: 'button',
                        text: '<i class="fa fa-plus"></i>',
                        handler: 'addSecondParty',
                        margin: '25 0 0 5'
                    },{
                        xtype: 'textfield',
                        fieldLabel: 'Catatan',
                        name: 'note',
                        margin: '0 0 0 20',
                        width: 200
                    }]
                },{
                    xtype: 'container',
                    anchor: '100%',
                    layout: 'hbox',
                    margin: '0 0 10 0',
                    items:[{
                        xtype: 'field-price',
                        fieldLabel: 'Harga Total',
                        name: 'total_price',
                        reference: 'total_price',
                        readOnly: true,
                        saveOnEnter: true,
                        width: 150
                    },{
                        xtype: 'field-price',
                        fieldLabel: 'Dibayar',
                        name: 'paid',
                        reference: 'paid',
                        saveOnEnter: true,
                        selectOnFocus: true,
                        margin: '0 0 0 20',
                        width: 150,
                        listeners: {
                            change: 'setBalance'
                        }
                    },{
                        xtype: 'field-price',
                        fieldLabel: 'Sisa',
                        name: 'balance',
                        reference: 'balance',
                        readOnly: true,
                        saveOnEnter: true,
                        margin: '0 0 0 20',
                        width: 150
                    }]
                }]
            },{
                xtype: 'toolbar',
                ui: 'footer',
                margin: '0 0 30 0',
                width: 900,
                items: ['->',
                {
                    text: '<i class="fa fa-save glyph"></i> Simpan',
                    handler: 'save'
                },{
                    text: '<i class="fa fa-undo glyph"></i> Batal',
                    handler: 'close'
                }]
            },{
                xtype: 'container',
                cls: 'panel',
                width: 900,
                items: [{
                    xtype: 'container',
                    html: 'Produk yang Dibeli',
                    cls: 'panel-header'
                },{
                    xtype: 'grid-purchase-detail',
                    reference: 'grid-purchase-detail',
                    dockedItems: [{
                        xtype: 'toolbar',
                        dock: 'top',
                        items: [{
                            text: '<i class="fa fa-plus-square glyph"></i> Tambah',
                            reference: 'add',
                            handler: 'add'
                        },{
                            text: '<i class="fa fa-edit glyph"></i> Ubah',
                            reference: 'edit',
                            handler: 'edit',
                            disabled: true
                        },{
                            text: '<i class="fa fa-trash-o glyph"></i> Hapus',
                            reference: 'delete',
                            handler: 'remove',
                            disabled: true
                        }]
                    }]
                }]
            }]
        }];

        this.callParent(arguments);
    }
});