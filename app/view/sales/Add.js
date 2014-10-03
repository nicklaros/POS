Ext.define('POS.view.sales.Add' ,{
    extend: 'Ext.panel.Panel',
    alias : 'widget.add-sales',
    id: 'add-sales',
    controller: 'add-sales',

    requires: [
        'POS.custom.field.ComboCashier',
        'POS.custom.field.ComboSecondParty',
        'POS.custom.field.Date',
        'POS.custom.field.Price',
        'POS.custom.grid.SalesDetail',
        'POS.store.sales.AddDetail',
        'POS.tpl.hint.Sales',
        'POS.view.sales.AddController',
        'POS.view.sales.AddDetail',
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
        this.title = '<i class="fa fa-shopping-cart glyph"></i> Penjualan Baru';

        this.items = [{
            xtype: 'container',
            layout: 'vbox',
            style: {
                margin: '25px auto'
            },
            width: 800,
            items: [{
                xtype: 'container',
                cls: 'panel',
                margin: '0 0 10 0',
                width: 800,
                items: [{
                    xtype: 'form',
                    reference: 'formPayment',
                    monitorValid: true,
                    bodyPadding: 10,
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
                            fieldLabel: 'Dijual Ke',
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
                            width: 150
                        },{
                            xtype: 'combo-cashier',
                            fieldLabel: 'Kasir',
                            name: 'cashier_id',
                            reference: 'cashier',
                            afterLabelTextTpl: REQUIRED,
                            allowBlank: false,
                            readOnly: true,
                            margin: '0 0 0 20',
                            width: 150
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
                    },{
                        xtype: 'hidden',
                        name: 'buy_price',
                        reference: 'buy_price'
                    }]
                }]
            },{
                xtype: 'toolbar',
                ui: 'footer',
                margin: '0 0 10 0',
                width: 800,
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
                    xtype: 'combo-sell-type',
                    name: 'type',
                    reference: 'type',
                    afterLabelTextTpl: REQUIRED,
                    allowBlank: false,
                    emptyText: 'Tipe',
                    tabOnEnter: true,
                    value: 'Public',
                    width: 150,
                    listeners: {
                        select: 'onTypeSelect'
                    }
                },{
                    xtype: 'combo-stock',
                    name: 'stock',
                    reference: 'stock',
                    afterLabelTextTpl: REQUIRED,
                    allowBlank: false,
                    emptyText: 'Scan Barcode atau ketikkan Produk',
                    margin: '0 0 0 5',
                    flex: 1,
                    listeners: {
                        select: 'onStockSelect',
                        blur: 'onStockBlur'
                    }
                },{
                    xtype: 'field-stock-amount',
                    name: 'amount',
                    reference: 'amount',
                    afterLabelTextTpl: REQUIRED,
                    allowBlank: false,
                    emptyText: 'Jumlah',
                    step: 1,
                    minValue: 0,
                    value: 1,
                    margin: '0 0 0 5',
                    width: 100,
                    listeners: {
                        specialkey: 'onAmountSpecialKey'
                    }
                },{
                    xtype: 'label',
                    reference: 'unit',
                    html: 'Unit',
                    margin: '5 0 0 5'
                }]
            },{
                xtype: 'container',
                cls: 'panel',
                width: 800,
                items: [{
                    xtype: 'grid-sales-detail',
                    reference: 'grid-sales-detail',
                    store: POS.app.getStore('sales.AddDetail'),
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
            tpl: Ext.create('POS.tpl.hint.Sales'),
            bind: {
                data: '{shortcutKeys}'
            }
        }];

        this.callParent(arguments);
    }
});