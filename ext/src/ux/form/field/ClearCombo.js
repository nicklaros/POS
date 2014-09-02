Ext.define('Ext.ux.form.field.ClearCombo', {
	extend: 'Ext.form.field.ComboBox',
	alias: 'widget.clearcombo',
    
    triggers: {
        picker: {
            handler: 'onTriggerClick', 
            scope: 'this'
        },
        trigger2: {
            cls: 'x-form-clear-trigger',
            handler: function(args) {
                this.onTrigger2Click(args);
            }
        }
    },

	initComponent: function () {
		var me = this;

		me.callParent(arguments);

		me.on('specialkey', this.onSpecialKeyDown, me);
		me.on('select', function (me, rec) {
			me.onShowClearTrigger(true); 
		}, me);
		me.on('change', function (me, rec) {
		    if(me.value!=null){
			    me.onShowClearTrigger(true);
		    }
		}, me);
		me.on('afterrender', function () { me.onShowClearTrigger(true); }, me);
	},

	/**
	* @private onSpecialKeyDown
	* eventhandler for special keys
	*/
	onSpecialKeyDown: function (obj, e, opt) {
		if ( e.getKey() == e.ESC )
		{
			this.clear();
		}
	},

	onShowClearTrigger: function (show) {
		var me = this;

		show = true;
		if (show) {
			me.triggerEl.each(function (el, c, i) {
				if (i === 1) {
					el.setWidth(el.originWidth, false);
					el.setVisible(true);
					me.active = true;
				}
			});
		} else {
			me.triggerEl.each(function (el, c, i) {
				if (i === 1) {
					el.originWidth = el.getWidth();
					el.setWidth(0, false);
					el.setVisible(false);
					me.active = false;
				}
			});
		}
		// ToDo -> Version specific methods
		if (Ext.lastRegisteredVersion.shortVersion > 407) {
			me.updateLayout();
		} else {
			me.updateEditState();
		}
	},

	/**
	* @override onTrigger2Click
	* eventhandler
	*/
	onTrigger2Click: function (args) {
		this.clear();
	},

	/**
	* @private clear
	* clears the current search
	*/
	clear: function () {
		var me = this;
		me.fireEvent('beforeclear', me);
		me.clearValue();
		me.onShowClearTrigger(true);
		me.fireEvent('clear', me);
	}
});