Ext.define('POS.view.notification.OptionController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.notification-option',

    control: {
        '#': {
            boxready: function(){
                this.loadPriceOption();
            }
        },
        '#option-price': {
            selectionchange: function(sm, selected){
                var sub = this.lookupReference('subOptionPrice');

                sub.setDisabled(selected.length !== 1);
            },
            itemkeydown : function(view, record, item, index, key) {
                if (key.getKey() == 46) { //the delete key
                    this.subOptionPrice();
                }  
            }
        }
    },
    
    addOptionPrice: function(){
        var panel = POS.fn.App.window('add-notification-option');
        
        panel.notificationType = 'price';
    },
    
    subOptionPrice: function(){
        var panel   = this.getView(),
            grid    = panel.down('#option-price'),
            store   = grid.getStore(),
            rec     = grid.getSelectionModel().getSelection()[0],
            params  = {
                id: rec.get('id')
            };

        panel.setLoading(true);
        var monitor = POS.fn.WebSocket.monitor(
            Ext.ws.Main.on('notification/subOptionPrice', function(websocket, result){
                clearTimeout(monitor);
                panel.setLoading(false);
                if (result.success){
                    store.load();
                }else{
                    POS.fn.App.notification('Ups', result.errmsg);
                }
            }, this, {
                single: true,
                destroyable: true
            })
        );
        Ext.ws.Main.send('notification/subOptionPrice', params);
    },
    
    loadPriceOption: function(){
        POS.app.getStore('notificationoption.Price').load();
    }
    
});
