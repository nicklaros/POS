Ext.define('POS.view.unit.AddController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.add-unit',

    control: {
        '#': {
            boxready: function(){
                var name = this.lookupReference('name');
                setTimeout(function(){
                    name.focus();
                }, 10);
            }
        },
        'textfield[saveOnEnter = true]': {
            specialkey: function(field, e){
                field.fireEvent('blur', field);
                if(e.getKey() == e.ENTER) this.save();
            }
        }
    },

    close: function(){
        this.getView().close();
    },

    save: function(){
        var panel = this.getView(),
            form = panel.down('form');

        if(form.getForm().isValid()){
            var values = form.getValues();

            panel.setLoading(true);
            var monitor = POS.fn.WebSocket.monitor(
                Ext.ws.Main.on('unit/create', function(websocket, result){
                    clearTimeout(monitor);
                    panel.setLoading(false);
                    if (result.success){
                        panel.close();
                        POS.app.getStore('Unit').load();
                        
                        var bindCombo = Ext.getCmp(panel.bindCombo);
                        
                        if (!Ext.isEmpty(bindCombo) && (bindCombo.xtype == 'combo-unit')) {                            
                            var unit = Ext.create('POS.model.Unit', result.data);
                            
                            bindCombo.getStore().add(unit);
                            
                            bindCombo.select(unit);
                            
                            bindCombo.fireEvent('select', bindCombo, [unit]);
                        }
                    }else{
                        POS.fn.App.notification('Ups', result.errmsg);
                        var name = this.lookupReference('name');
                        setTimeout(function(){
                            name.focus();
                        }, 10);
                    }
                }, this, {
                    single: true,
                    destroyable: true
                }),
                panel,
                false
            );
            Ext.ws.Main.send('unit/create', values);
        }
    }
});
