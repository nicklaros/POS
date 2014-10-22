Ext.define('POS.view.credit.ListPaymentController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.list-credit-payment',

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
            '<i class="fa fa-exclamation-triangle glyph"></i> Batalkan Pembayaran Piutang',
            'Apakah Anda yakin akan membatalkan Pembayaran Piutang ini?',
            function(btn){
                if (btn == 'yes'){
                    POS.fn.App.setLoading(true);
                    var monitor = POS.fn.WebSocket.monitor(
                        Ext.ws.Main.on('credit/cancelPayment', function(websocket, result){
                            clearTimeout(monitor);
                            POS.fn.App.setLoading(false);
                            POS.app.getStore('Credit').load();
                            POS.app.getStore('CreditPayment').load();
                            if (result.success == false) {
                                POS.fn.App.notification('Ups', result.errmsg);
                            }
                        }, this, {
                            single: true,
                            destroyable: true
                        })
                    );
                    Ext.ws.Main.send('credit/cancelPayment', params);
                }
            }
        );
    },
    
    search: function(){
        POS.fn.App.window('search-credit-payment');
    },
    
    reset: function(){
        this.getView().getStore().search({});
    }
});
