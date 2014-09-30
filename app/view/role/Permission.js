Ext.define('POS.view.role.Permission' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.role-permission',
    id: 'role-permission',
    controller: 'role-permission',

    requires: [
        'POS.view.role.PermissionController'
    ],

    layout: 'anchor',
    
    autoScroll: true,
    autoShow: true,
    constrain: true,
    resizable: false,
    width: 600,

    initComponent: function(){
        this.title = '<i class="fa fa-briefcase glyph"></i> Hak Akses Jabatan';

        this.items = [{
            xtype: 'form',
            monitorValid: true,
            bodyPadding: 10,
            items: [{
                xtype: 'hidden',
                name: 'id'
            },{
                xtype: 'fieldset',
                title: 'Penjualan',
                anchor: '100%',
                layout: 'hbox',
                margin: '10 0 10 0',
                padding: 10,
                items:[{
                    xtype: 'checkbox',
                    boxLabel: 'Lihat',
                    name: 'read_sales',
                    inputValue: true
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Buat',
                    name: 'create_sales',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Ubah',
                    name: 'update_sales',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Batalkan',
                    name: 'destroy_sales',
                    inputValue: true,
                    margin: '0 0 0 50'
                }]
            },{
                xtype: 'fieldset',
                title: 'Pembelian',
                anchor: '100%',
                layout: 'hbox',
                margin: '10 0 10 0',
                padding: 10,
                items:[{
                    xtype: 'checkbox',
                    boxLabel: 'Lihat',
                    name: 'read_purchase',
                    inputValue: true
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Buat',
                    name: 'create_purchase',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Ubah',
                    name: 'update_purchase',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Batalkan',
                    name: 'destroy_purchase',
                    inputValue: true,
                    margin: '0 0 0 50'
                }]
            },{
                xtype: 'fieldset',
                title: 'Piutang Penjualan',
                anchor: '100%',
                layout: 'hbox',
                margin: '10 0 10 0',
                padding: 10,
                items:[{
                    xtype: 'checkbox',
                    boxLabel: 'Lihat',
                    name: 'read_credit',
                    inputValue: true
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Bayar',
                    name: 'pay_credit',
                    inputValue: true,
                    margin: '0 0 0 50'
                }]
            },{
                xtype: 'fieldset',
                title: 'Hutang Pembelian',
                anchor: '100%',
                layout: 'hbox',
                margin: '10 0 10 0',
                padding: 10,
                items:[{
                    xtype: 'checkbox',
                    boxLabel: 'Lihat',
                    name: 'read_debit',
                    inputValue: true
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Bayar',
                    name: 'pay_debit',
                    inputValue: true,
                    margin: '0 0 0 50'
                }]
            },{
                xtype: 'fieldset',
                title: 'Satuan',
                anchor: '100%',
                layout: 'hbox',
                margin: '10 0 10 0',
                padding: 10,
                items:[{
                    xtype: 'checkbox',
                    boxLabel: 'Lihat',
                    name: 'read_unit',
                    inputValue: true
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Buat',
                    name: 'create_unit',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Ubah',
                    name: 'update_unit',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Hapus',
                    name: 'destroy_unit',
                    inputValue: true,
                    margin: '0 0 0 50'
                }]
            },{
                xtype: 'fieldset',
                title: 'Produk',
                anchor: '100%',
                layout: 'hbox',
                margin: '10 0 10 0',
                padding: 10,
                items:[{
                    xtype: 'checkbox',
                    boxLabel: 'Lihat',
                    name: 'read_product',
                    inputValue: true
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Buat',
                    name: 'create_product',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Ubah',
                    name: 'update_product',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Hapus',
                    name: 'destroy_product',
                    inputValue: true,
                    margin: '0 0 0 50'
                }]
            },{
                xtype: 'fieldset',
                title: 'Stock',
                anchor: '100%',
                layout: 'hbox',
                margin: '10 0 10 0',
                padding: 10,
                items:[{
                    xtype: 'checkbox',
                    boxLabel: 'Lihat',
                    name: 'read_stock',
                    inputValue: true
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Buat',
                    name: 'create_stock',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Ubah',
                    name: 'update_stock',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Hapus',
                    name: 'destroy_stock',
                    inputValue: true,
                    margin: '0 0 0 50'
                }]
            },{
                xtype: 'fieldset',
                title: 'Supplier dan Pelanggan',
                anchor: '100%',
                layout: 'hbox',
                margin: '10 0 10 0',
                padding: 10,
                items:[{
                    xtype: 'checkbox',
                    boxLabel: 'Lihat',
                    name: 'read_second_party',
                    inputValue: true
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Buat',
                    name: 'create_second_party',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Ubah',
                    name: 'update_second_party',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Hapus',
                    name: 'destroy_second_party',
                    inputValue: true,
                    margin: '0 0 0 50'
                }]
            },{
                xtype: 'fieldset',
                title: 'Pegawai',
                anchor: '100%',
                layout: 'hbox',
                margin: '10 0 10 0',
                padding: 10,
                items:[{
                    xtype: 'checkbox',
                    boxLabel: 'Lihat',
                    name: 'read_user',
                    inputValue: true
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Buat',
                    name: 'create_user',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Ubah',
                    name: 'update_user',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Hapus',
                    name: 'destroy_user',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Reset Password',
                    name: 'reset_pass_user',
                    inputValue: true,
                    margin: '0 0 0 50'
                }]
            },{
                xtype: 'fieldset',
                title: 'Jabatan',
                anchor: '100%',
                layout: 'hbox',
                margin: '10 0 10 0',
                padding: 10,
                items:[{
                    xtype: 'checkbox',
                    boxLabel: 'Lihat',
                    name: 'read_role',
                    inputValue: true
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Buat',
                    name: 'create_role',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Ubah',
                    name: 'update_role',
                    inputValue: true,
                    margin: '0 0 0 50'
                },{
                    xtype: 'checkbox',
                    boxLabel: 'Hapus',
                    name: 'destroy_role',
                    inputValue: true,
                    margin: '0 0 0 50'
                }]
            }]
        }];

        this.dockedItems = [{
            xtype: 'toolbar',
            dock: 'top',
            ui: 'footer',
            items: [{
                text: '<i class="fa fa-save glyph"></i> Simpan',
                handler: 'save'
            },{
                text: '<i class="fa fa-undo glyph"></i> Batal',
                handler: 'close'
            }]
        }];

        this.maxHeight = Ext.getBody().getViewSize().height;

        this.callParent(arguments);
    }
});