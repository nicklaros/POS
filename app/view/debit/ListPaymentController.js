Ext.define('POS.view.debit.ListPaymentController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.list-debit-payment',

    control: {
        '#': {
            selectionchange: function(sm, selected){
                var cancel      = this.lookupReference('cancel');

                cancel.setDisabled(selected.length !== 1);
            }
        }
    },
    
    cancel: function(){
        var record     = this.getView().getSelectionModel().getSelection()[0],
            params     = {
                id: record.get('id')
            };

        Ext.Msg.confirm(
            '<i class="fa fa-exclamation-triangle glyph"></i> Batalkan Pembayaran Hutang',
            'Apakah Anda yakin akan membatalkan Pembayaran Hutang ini?',
            function(btn){
                if (btn == 'yes'){
                    POS.fn.App.setLoading(true);
                    var monitor = POS.fn.WebSocket.monitor(
                        Ext.ws.Main.on('debit/cancelPayment', function(websocket, result){
                            clearTimeout(monitor);
                            POS.fn.App.setLoading(false);
                            POS.app.getStore('Debit').load();
                            POS.app.getStore('DebitPayment').load();
                            if (result.success == false) {
                                POS.fn.App.notification('Ups', result.errmsg);
                            }
                        }, this, {
                            single: true,
                            destroyable: true
                        })
                    );
                    Ext.ws.Main.send('debit/cancelPayment', params);
                }
            }
        );
    },
    
    search: function(){
        POS.fn.App.window('search-debit-payment');
    },
    
    reset: function(){
        this.getView().getStore().search({});
    }
});
