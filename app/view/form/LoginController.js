Ext.define('POS.view.form.LoginController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.login',

    requires: [
        'POS.fn.Util',
        'Ext.MessageBox'
    ],

    control: {
        'textfield[tabOnEnter = true]': {
            specialkey: function(field, e){
                if(e.getKey() == e.ENTER) field.next('field').focus();
            }
        },
        'textfield[saveOnEnter = true]': {
            specialkey: function(f, e){
                if(e.getKey() == e.ENTER) this.login();
            }
        }
    },

    blurPass: function(field){
        var pass = this.lookupReference('pass'),
            val = field.getValue();

        pass.setValue(val != "" ? POS.fn.Util.SHA512(val) : "");
    },

    login: function () {
        var	form = this.getView(),
            pass = this.lookupReference('pass_unencrypted');

        if(form.getForm().isValid()){
            form.setLoading(true);

            this.blurPass(pass);

            Mains.login(form.getValues(), function (result) {
                form.setLoading(false);
                if(result.success){
                    var appTab = Ext.ComponentQuery.query('app-tab')[0],
                        tabItems = appTab.items.items,
                        tabLength = tabItems.length;

                    appTab.setActiveTab(0);
                    for(i=1;i<tabLength;i++){
                        tabItems[1].close();
                    }

                    Ext.main.ViewModel.setData(result);

                    POS.fn.Util.afterLogin();

                    form.getForm().reset();
                }else{
                    Ext.Msg.alert('Login Gagal!', result.errmsg,
                        function(btn){
                            if (btn){
                                pass.focus();
                            }
                        }
                    );
                    pass.reset();
                }
            });
        }
    }
});
