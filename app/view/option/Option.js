Ext.define('POS.view.option.Option' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.app-option',
    id: 'app-option',
    controller: 'app-option',

    requires: [
        'POS.view.option.Photo',
        'POS.view.option.Identity',
        'POS.view.option.OptionController'
    ],

    layout: 'anchor',
    
	autoScroll: false,
    autoShow: true,
    bodyStyle: {
        'background-color': '#e9eaed',
        border: '0 !important'
    },
    cls: 'window',
    constrain: true,
    header: false,
    modal: true,
    resizable: false,
    
    padding: 0,
    width: 600,

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
                margin: '5 0 0 0',
                html: '<i class="fa fa-cogs glyph"></i> Pengaturan Aplikasi'
            },{
                xtype: 'container',
                flex: 1
            },{
                xtype: 'buttonsegment',
                items: [{
                    text: 'x',
                    handler: 'close'
                }]
            }]
        }];
        
        this.items = [{
            xtype: 'tabpanel',
            activeTab: 0,
			bodyStyle: {
				border: '0 !important'
			},
            maxHeight: Ext.getBody().getViewSize().height - 52,
            items: [{
                xtype: 'panel',
                title: 'Identitas Perusahaan',
	            autoScroll: true,
                bodyStyle: {
                    'background-color': '#e9eaed',
                    border: '0 !important'
                },
                items: [{
                    xtype: 'option-identity',
                    style: {
                        margin: '25px auto'
                    },
                    width: 550
                }]
            },{
                xtype: 'panel',
                title: 'Gambar Depan',
	            autoScroll: true,
                bodyStyle: {
                    'background-color': '#e9eaed',
                    border: '0 !important'
                },
                items: [{
                    xtype: 'option-photo',
                    style: {
                        margin: '25px auto'
                    },
                    width: 550
                }]
            }]
        }];

        this.maxHeight = Ext.getBody().getViewSize().height;

        this.callParent(arguments);
    }
});