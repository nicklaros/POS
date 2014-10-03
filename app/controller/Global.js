Ext.define('POS.controller.Global', {
    extend: 'Ext.app.Controller',

    init: function() {
        this.listen({
            component: {
                'textfield[tabOnEnter = true]': {
                    specialkey: function(field, e){
                        if(e.getKey() == e.ENTER) {
                            setTimeout(function(){
                                field.next('field').focus();
                            }, 10);
                        }
                    }
                }
            }
        });
    }
});