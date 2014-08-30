Ext.define('Ext.ux.form.field.ClearCombo', {
	extend: 'Ext.form.field.ComboBox',
	alias: 'widget.clearcombo',
	
	trigger2Cls: 'x-form-clear-trigger',

	initComponent: function () {
		var me = this;


		me.addEvents(
			/**
			* @event beforeclear
			*
			* @param {<|#NAMESPACE#|>.FilterCombo} FilterCombo The filtercombo that triggered the event
			*/
			'beforeclear',
			/**
			* @event beforeclear
			*
			* @param {<|#NAMESPACE#|>.FilterCombo} FilterCombo The filtercombo that triggered the event
			*/
			'clear'
		);

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

		show = ( Ext.isBoolean( show ) ) ? show : true;
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
		me.updateLayout();
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