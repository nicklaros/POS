Ext.define('POS.view.DeveloperInfo' ,{
    extend: 'Ext.window.Window',
    alias : 'widget.developer-info',
    
    requires: [
        'POS.tpl.DeveloperInfo'
    ],

	layout: 'fit',
    autoShow: true,
    header: false,
    modal:true,
    style: {
        border: '1px solid #e6e6e6',
        'border-radius': '2px'
    },
    width: 460,
    height: 400,
    bind: {
        data: '{info}'
    },

    initComponent: function() {
		this.tpl = Ext.create('POS.tpl.DeveloperInfo');
		
        this.callParent(arguments);

        this.mon(Ext.getBody(), 'click', function(el, e){
            this.close(this.closeAction);
        }, this, { delegate: '.x-mask' });
    }
});