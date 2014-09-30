Ext.define('POS.view.notification.AddOption' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.add-notification-option',
    id: 'add-notification-option',
    controller: 'add-notification-option',

    requires: [
        'POS.custom.field.ComboRole',
        'POS.view.notification.AddOptionController'
    ],

    layout: 'anchor',
    
    autoShow: true,
    constrain: true,
    resizable: false,
    width: 350,
    
    bindCombo: null,

    initComponent: function(){
        this.title = '<i class="fa fa-bell-o glyph"></i> Tambahkan Pemberitahuan Untuk Jabatan';

        this.items = [{
            xtype: 'form',
            monitorValid: true,
            bodyPadding: 10,
            items: [{
                xtype: 'combo-role',
                fieldLabel: 'Jabatan',
                name: 'role',
                reference: 'role',
                afterLabelTextTpl: REQUIRED,
                allowBlank: false,
                width: 150
            }]
        }];

        this.dockedItems = [{
            xtype: 'toolbar',
            dock: 'top',
            ui: 'footer',
            items: [{
                text: '<i class="fa fa-plus glyph"></i> Tambahkan',
                handler: 'save'
            },{
                text: '<i class="fa fa-undo glyph"></i> Batal',
                handler: 'close'
            }]
        }];

        this.callParent(arguments);
    }
});