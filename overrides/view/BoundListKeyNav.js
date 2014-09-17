Ext.define('Overrides.view.BoundListKeyNav', { 
    override: 'Ext.view.BoundListKeyNav', 
    initKeyNav: function(view) { 
        var me = this, 
            field = me.view.pickerField; 


        // BoundLists must be able to function standalone with no bound field 
        if (!view.pickerField) { 
            return; 
        } 

        if (!field.rendered) { 
            field.on('render', Ext.Function.bind(me.initKeyNav, me, [view], 0), me, {single: true}); 
            return; 
        } 

        me.keyNav = new Ext.util.KeyNav({ 
            target: field.inputEl, 
            forceKeyDown: true, 
            up: me.onKeyUp, 
            down: me.onKeyDown, 
            right: me.onKeyRight, 
            left: me.onKeyLeft, 
            pageDown: me.onKeyPageDown, 
            pageUp: me.onKeyPageUp, 
            home: me.onKeyHome, 
            end: me.onKeyEnd, 
            tab: me.onKeyTab, 
//            space: me.onKeySpace, 
            enter: me.onKeyEnter, 
            scope: me 
        }); 


    } 
});  