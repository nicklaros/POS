Ext.define('POS.view.purchase.Edit', {
    extend: 'Ext.panel.Panel',
    alias : 'widget.edit-purchase',
    id: 'edit-purchase',
    controller: 'edit-purchase',

    requires: [
        'POS.custom.field.ComboSecondParty',
        'POS.custom.field.Date',
        'POS.custom.field.Price',
        'POS.custom.grid.PurchaseDetail',
        'POS.store.purchase.EditDetail',
        'POS.tpl.hint.Purchase',
        'POS.view.purchase.EditController',
        'POS.view.purchase.EditDetail',
        'POS.view.secondparty.Add'
    ],

    layout: 'anchor',
    
    autoScroll: true,
    autoShow: true,
    bodyStyle: {
        'background-color': '#e9eaed',
        border: '0 !important'
    },
    columnLines: true,
    closable: true,
    closeAction: 'hide',

    initComponent: function(){
        this.title = '<i class="fa fa-truck glyph"></i> Ubah Data Pembelian';

        this.items = [{
            xtype: 'container',
            layout: 'vbox',
            style: {
                margin: '25px auto'
            },
            width: 900,
            items: [{
                xtype: 'form',
                reference: 'formPayment',
                bodyPadding: 10,
                cls: 'panel',
                monitorValid: true,
                margin: '0 0 10 0',
                width: 900,
                items: [{
                    xtype: 'hidden',
                    name: 'id'
                },{
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
                        fieldCls: 'field-highlight',
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
                margin: '0 0 10 0',
                width: 900,
                items: ['->',
                {
                    text: '<i class="fa fa-save glyph"></i> [Alt + S] Simpan',
                    handler: 'save'
                },{
                    text: '<i class="fa fa-undo glyph"></i> [Esc] Batal',
                    handler: 'close'
                }]
            },{
                xtype: 'form',
                reference: 'formAddDetail',
                bodyStyle: {
                    'background-color': '#e9eaed'
                },
                layout: 'hbox',
                monitorValid: true,
                margin: '5 0 5 0',
                width: '100%',
                items: [{
                    xtype: 'combo-product',
                    name: 'product',
                    reference: 'product',
                    afterLabelTextTpl: REQUIRED,
                    allowBlank: false,
                    emptyText: 'Scan Barcode atau ketikkan Produk',
                    flex: 1,
                    listeners: {
                        clear: 'onProductClear',
                        select: 'onProductSelect',
                        blur: 'onProductBlur'
                    }
                },{
                    xtype: 'button',
                    text: '<i class="fa fa-plus"></i>',
                    handler: 'addProduct',
                    height: 24
                },{
                    xtype: 'combo-stock-variant',
                    name: 'stock',
                    reference: 'stock',
                    afterLabelTextTpl: REQUIRED,
                    allowBlank: false,
                    emptyText: 'Variant',
                    margin: '0 0 0 5',
                    width: 125,
                    listeners: {
                        select: 'onStockSelect'
                    }
                },{
                    xtype: 'button',
                    text: '<i class="fa fa-plus"></i>',
                    reference: 'add_variant',
                    handler: 'addVariant',
                    height: 24
                },{
                    xtype: 'field-stock-amount',
                    name: 'amount',
                    reference: 'amount',
                    afterLabelTextTpl: REQUIRED,
                    allowBlank: false,
                    emptyText: 'Jumlah',
                    step: 1,
                    tabOnEnter: true,
                    minValue: 0,
                    value: 1,
                    margin: '0 0 0 5',
                    width: 85
                },{
                    xtype: 'field-price',
                    name: 'sub_total_price',
                    reference: 'sub_total_price',
                    afterLabelTextTpl: REQUIRED,
                    allowBlank: false,
                    emptyText: 'Sub Total',
                    selectOnFocus: true,
                    margin: '0 0 0 5',
                    width: 150,
                    listeners: {
                        specialkey: 'onTotalPriceKey'
                    }
                }]
            },{
                xtype: 'container',
                cls: 'panel',
                width: 900,
                items: [{
                    xtype: 'grid-purchase-detail',
                    reference: 'grid-purchase-detail',
                    store: POS.app.getStore('purchase.EditDetail'),
                    withRowNumber: true,
                    dockedItems: [{
                        xtype: 'toolbar',
                        dock: 'top',
                        items: [{
                            text: '<i class="fa fa-edit glyph"></i> Ubah',
                            reference: 'edit',
                            handler: 'edit',
                            disabled: true
                        },{
                            text: '<i class="fa fa-trash-o glyph"></i> [Del] Hapus',
                            reference: 'delete',
                            handler: 'remove',
                            disabled: true
                        }]
                    }]
                }]
            }]
        }];
        
        this.dockedItems = [{
            xtype: 'container',
            dock: 'top',
            style: {
                'background-color': '#FF4141'
            },
            tpl: Ext.create('POS.tpl.hint.Purchase'),
            bind: {
                data: '{shortcutKeys}'
            }
        }];

        this.callParent(arguments);
    }
});