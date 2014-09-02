/*
 * MIT License
 *
 * Copyright (C) 2014 Nick Laros
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files 
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, 
 * publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, 
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, 
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE 
 * OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @description: Extension to display currency in a field
 *
 * @author: Nick Laros
 * @email: nicklaros@gmail.com
 * @version: 5 - for ExtJS version 5
 */
Ext.define('Ext.ux.form.field.Currency',
{
    extend: 'Ext.form.field.Text',
    alias: 'widget.currencyfield',
    
    alwaysDisplayDecimals: false,
    fieldStyle: 'text-align: right;',
    maskRe: /[0-9]/,
    symbol: '$',
    thousandSeparator: ',',
    useThousandSeparator: true,
    value: 0,
    
    initComponent: function(){
        if (this.useThousandSeparator && this.decimalSeparator == ',' && this.thousandSeparator == ',')
            this.thousandSeparator = '.';
        else
            if (this.allowDecimals && this.thousandSeparator == '.' && this.decimalSeparator == '.')
                this.decimalSeparator = ',';
       
        this.callParent(arguments);
    },
    
    /**
     * Override setValue.
     */
    setValue: function(value){
        Ext.form.field.Text.superclass.setValue.call(this, value != null ? value.toString().replace('.', this.decimalSeparator) : value);
       
        this.setRawValue(this.getFormattedValue(this.getValue()));
    },
    
    /**
     * Get value after format added.
     */
    getFormattedValue: function(value){
        if (Ext.isEmpty(value) || !this.hasFormat())
            return value;
        else
        {
            var neg = null;
           
            value = (neg = value < 0) ? value * -1 : value;
            value = this.allowDecimals && this.alwaysDisplayDecimals ? value.toFixed(this.decimalPrecision) : value;
           
            if (this.useThousandSeparator)
            {
                if (this.useThousandSeparator && Ext.isEmpty(this.thousandSeparator))
                    throw ('NumberFormatException: invalid thousandSeparator, property must has a valid character.');
               
                if (this.thousandSeparator == this.decimalSeparator)
                    throw ('NumberFormatException: invalid thousandSeparator, thousand separator must be different from decimalSeparator.');
               
                value = value.toString();
               
                var ps = value.split('.');
                ps[1] = ps[1] ? ps[1] : null;
               
                var whole = ps[0];
               
                var r = /(\d+)(\d{3})/;
               
                var ts = this.thousandSeparator;
               
                while (r.test(whole))
                    whole = whole.replace(r, '$1' + ts + '$2');
               
                value = whole + (ps[1] ? this.decimalSeparator + ps[1] : '');
            }
           
            return Ext.String.format('{0}{1}{2}', (neg ? '-' : ''), (Ext.isEmpty(this.symbol) ? '' : this.symbol + ' '), value);
        }
    },
    
    /**
     * overrides parseValue to remove the format applied by this class
     */
    parseValue: function(value){
        //Replace the currency symbol and thousand separator
        return Ext.form.field.Text.superclass.parseValue.call(this, this.removeFormat(value));
    },
    
    /**
     * Internal method to remove format added by this class
     * @param {Object} value
     */
    removeFormat: function(value){
        if (Ext.isEmpty(value) || !this.hasFormat())
            return value;
        else
        {
            value = value.toString().replace(this.symbol + ' ', '');
           
            value = this.useThousandSeparator ? value.replace(new RegExp('[' + this.thousandSeparator + ']', 'g'), '') : value;
           
            return value;
        }
    },
    
    /**
     * Remove the format before validating the the value.
     * @param {Number} value
     */
    getErrors: function(value){
        return Ext.form.field.Text.superclass.getErrors.call(this, this.removeFormat(value));
    },
    
    /**
     * Check whether field has format.
     */
    hasFormat: function(){
        return this.decimalSeparator != '.' || (this.useThousandSeparator == true && this.getRawValue() != null) || !Ext.isEmpty(this.symbol) || this.alwaysDisplayDecimals;
    },
    
    /**
     * Remove field format.
     */
    onFocus: function(){
        var value = this.removeFormat(this.getRawValue());
        
        this.setRawValue(value == 0 ? '' : value);
       
        this.callParent(arguments);
    },
    
    /**
     * Reformat field.
     */
    onBlur: function(){
        var value = this.getValue().toString().replace(/\D/g,'');

        this.setRawValue(this.getFormattedValue(value == '' ? 0 : value));
       
        this.callParent(arguments);
    },
        
    /**
     * Get pure value without added format.
     */
    getSubmitValue: function() {
        return this.removeFormat(this.getValue());
    }
});