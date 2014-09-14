Ext.define('POS.view.notification.ListController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.list-notification',

    control: {
        'grid-notification': {
            itemclick: function(view, record){
                Ext.fn.App.newTab('list-stock');
                
                POS.app.getStore('POS.store.Stock').search({
                    product_id: record.data.product_id
                });
                
                this.getView().close();
            }
        }
    },

    clear: function(){
        Ext.Msg.confirm(
            '<i class="fa fa-exclamation-triangle glyph"></i> Bersihkan Pemberitahuan',
            'Apakah Anda yakin akan membersihkan semua pemberitahuan?',
            function(btn){
                if (btn == 'yes'){
                    var store = POS.app.getStore('POS.store.Notification');
                    
                    var id = []
                    store.each(function(record){
                        id.push(record.get('id'));
                    });
                    
                    Ext.fn.App.removeNotification(id);
                }
            }
        );
    },

    close: function(){
        this.getView().close();
    }
    
});
