Ext.define('POS.view.option.Photo', {
    extend: 'Ext.container.Container',
    alias: 'widget.option-photo',
    controller: 'option-photo',

    requires: [
        'POS.tpl.AppPhoto',
        'POS.view.option.PhotoController'
    ],
    
    layout: 'vbox',
    
    initComponent: function(){
        this.items = [{
            xtype: 'form',
            bodyStyle: {
                'background-color': '#e9eaed',
                border: '0 !important'
            },
            monitorValid:true,
            api: {
                submit: Mains.changeAppPhoto
            },
            items: [{
                xtype: 'container',
                reference: 'photo',
                cls: 'panel',
                html: '<img src="resources/images/image_700x300.fw.png" style="width: 550px; height: 250px; " />',
                bind: {
                    html: '<img src="resources/images/{info.app_photo}" style="width: 550px; height: 250px; " />'
                },
                width: 550,
                height: 250
            },{
                xtype: 'filefield',
                name: 'photo',
                buttonText: '<i class="fa fa-upload glyph"></i> Ubah Foto',
                regex: REGEX_0,
                regexText: REGEX_ERROR_0,
                buttonOnly: true,
                margin: '15 0 0 0',
                listeners: {
                    change: 'save'
                }
            }]
        }];

        this.callParent(arguments);
    }
});