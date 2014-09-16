Ext.define('POS.view.sales.Add' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.add-sales',
    id: 'add-sales',
    controller: 'add-sales',

    requires: [
        'POS.custom.field.ComboCashier',
        'POS.custom.field.ComboCustomer',
        'POS.custom.field.Date',
        'POS.custom.field.Price',
        'POS.custom.grid.SalesDetail',
        'POS.custom.panel.hint.Sales',
        'POS.view.sales.AddController',
        'POS.view.sales.AddDetail'
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
        this.title = '<i class="fa fa-shopping-cart glyph"></i> Penjualan Baru';

        this.items = [{
            xtype: 'container',
            layout: 'vbox',
            style: {
                margin: '0 auto'
            },
            width: 900,
            items: [{
                xtype: 'sales-hint',
                bind: {
                    data: '{shortcutKeys}'
                },
                margin: '0 0 20 0',
                width: 900
            },{
                xtype: 'container',
                cls: 'panel',
                margin: '0 0 10 0',
                width: 900,
                items: [{
                    xtype: 'form',
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
                            xtype: 'combo-customer',
                            fieldLabel: 'Pelanggan',
                            name: 'customer_id',
                            reference: 'customer',
                            afterLabelTextTpl: REQUIRED,
                            allowBlank: false,
                            margin: '0 0 0 20',
                            width: 200
                        },{
                            xtype: 'textfield',
                            fieldLabel: 'Catatan',
                            name: 'note',
                            margin: '0 0 0 20',
                            width: 200
                        },{
                            xtype: 'combo-cashier',
                            fieldLabel: 'Kasir',
                            name: 'cashier_id',
                            reference: 'cashier',
                            afterLabelTextTpl: REQUIRED,
                            allowBlank: false,
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
                            width: 150
                        },{
                            xtype: 'field-price',
                            fieldLabel: 'Sisa',
                            name: 'balance',
                            reference: 'balance',
                            raedOnly: true,
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
                    html: 'Produk yang Dijual',
                    cls: 'panel-header'
                },{
                    xtype: 'grid-sales-detail',
                    reference: 'grid-sales-detail',
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