Ext.define('POS.view.notification.ListController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.list-notification',

    clear: function(){
        Ext.Msg.confirm(
            '<i class="fa fa-exclamation-triangle glyph"></i> Bersihkan Pemberitahuan',
            'Apakah Anda yakin akan membersihkan semua pemberitahuan?',
            function(btn){
                if (btn == 'yes'){
                    var store = POS.app.getStore('Notification');
                    
                    var id = [];
                    store.each(function(record){
                        id.push(record.get('id'));
                    });
                    
                    POS.fn.Notification.remove(id);
                }
            }
        );
    },

    close: function(){
        this.getView().close();
    }
    
});
