Ext.define('Ext.fn.App', {
    singleton: true,

    init: function(){
        // Create WebSocket container
        Ext.ws = {};

        // Initialize QuickTips
        Ext.QuickTips.init();

        // Initiating
        Ext.ComponentQuery.query('app-main')[0].getViewModel().setData(App.init);

        if(App.init.state == 1){ // if already loged in then
            Ext.fn.Util.afterLogin();
        }

        console.log('Application successfully initiated.');

        //Ext.fn.Util.keyMap();
    },

    mnChangeBiodata: function(){
        Ext.widget('ubah-biodata');
    },

    mnChangePassword: function(){
        Ext.widget('ubah-password');
    },

    mnDashboard: function(){
        Ext.ComponentQuery.query('app-tab')[0].setActiveTab(0);
    },

    mnDeveloperInfo: function(){
        Ext.widget('about-dev');
    },

    mnListProduct: function(){
        this.newTab('list-product');
    },

    mnListStock: function(){
        this.newTab('list-stock');
    },

    mnListUser: function(){
        this.newTab('list-user');
    },

    mnLogout: function(){
        Mains.logout(function(result){
            if (result.success){
                var appTab = Ext.ComponentQuery.query('app-tab')[0],
                    tabItems = appTab.items.items,
                    tabLength = tabItems.length;

                appTab.setActiveTab(0);
                for(i=1;i<tabLength;i++){
                    tabItems[1].close();
                }

                Ext.ComponentQuery.query('app-main')[0].getViewModel().setData(result);

                Ext.fn.Util.afterLogout();

                setTimeout(function(){
                    Ext.ComponentQuery.query('login textfield[name=user]')[0].focus();
                }, 10);
            }else{
                console.log('Login error');
            }
        });
    },

    newTab: function(alias, state){
        var main = Ext.ComponentQuery.query('app-main')[0].getViewModel(),
            tab = Ext.ComponentQuery.query('app-tab')[0],
            panel = Ext.ComponentQuery.query(alias)[0];

        state = (typeof(state) === 'undefined' ? 1 : state)
        if(
            (state == 0) ||
            ( (state == 1) && (main.get('state') == 1) )
        ){
            if(!panel){
                tab.add({xtype:alias}).show();
            }else{
                tab.setActiveTab(panel);
            }
        }else{
            Ext.Msg.alert('Akses ditolak', E0);
        }
    },

    notify: function(title, message){
        return this.notification(title, message);
    },

    notification: function(title, message, icon){
        Ext.create('widget.uxNotification', {
            title: '<i class="fa fa-' + (icon || 'exclamation-triangle') + ' glyph"></i> ' + title,
            position: 'br',
            cls: 'ux-notification-light',
            html: message,
            autoCloseDelay: 4000,
            slideBackDuration: 500,
            slideInAnimation: 'bounceOut',
            slideBackAnimation: 'easeIn',
            maxWidth: 350
        }).show();
    },

    setLoading: function(bool){
        if (bool){
            Ext.WindowManager.each(function(window){
                Ext.main.Windows.push(window);
                window.hide();
            });
        }else{
            Ext.main.Windows.forEach(function(window){
                if (window.id){
                    var current;
                    if (current = Ext.getCmp(window.id)) current.show();
                }
            });
            Ext.main.Windows = [];
        }
        if (Ext.main.View) Ext.main.View.setLoading(bool);
    },

    window: function(id){
        var window = Ext.getCmp(id);
        window ? window.show() : window = Ext.widget(id);
        return window;
    }
});