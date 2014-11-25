/*!
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @version 1.3.0
 *
 * Client validation extension for the yii2-field-range extension
 * 
 * Author: Kartik Visweswaran
 * Copyright: 2014, Kartik Visweswaran, Krajee.com
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */
(function ($) {
    var isArray = function (a) {
        return Object.prototype.toString.call(a) === '[object Array]' || 
            Object.prototype.toString.call(a) === '[object Object]';
    };
    var KvFieldRange = function (element, options) {
        this.$attrTo = $(element);
        this.$attrFrom = $("#" + options.attrFrom);
        this.$mainContainer = $("#" + options.container);
        this.$errorContainer = $("#" + options.errorContainer);
        this.$errorBlockFrom = this.$attrFrom.closest('.kv-container-from').find('.help-block');
        this.$errorBlockTo = this.$attrTo.closest('.kv-container-to').find('.help-block');
        this.$errorBlock = this.$errorContainer.find('.help-block');
        this.$form = this.$attrFrom.closest('form');
        this.errorToMsg = "";
        this.init();
    };

    KvFieldRange.prototype = {
        constructor: KvFieldRange,
        init: function () {
            var self = this;
            self.$errorBlockFrom.hide();
            self.$errorBlockTo.hide();
            self.$form.on('reset.yiiActiveForm', function () {
                setTimeout(function () {
                    self.reset();
                }, 100);
            });
            self.$form.on('afterValidate', function (event, messages) {
                var idFrom = self.$attrFrom.attr('id'), idTo = self.$attrTo.attr('id');
                if (idFrom in messages) {
                    self.validateAttribute(messages[idFrom], idFrom, idTo);
                }
                if (idTo in messages) {
                    self.validateAttribute(messages[idTo], idFrom, idTo);
                }
            });
            self.$form.on('afterValidateAttribute', function (event, attribute, messages) {
                var idFrom = self.$attrFrom.attr('id'), idTo = self.$attrTo.attr('id');
                self.$errorBlock.html('');
                self.$errorContainer.removeClass('has-success has-error');
                if (attribute.id == idFrom || attribute.id == idTo) {
                    self.validateAttribute(messages, idFrom, idTo);
                }
            });
        },
        validateAttribute: function (msg, idFrom, idTo) {
            var self=this, len = msg.length, errMsg = '';
            if (isArray(msg) && len) {
                errMsg = len == 1 ? msg[0] : msg.join('</li><li>');
            } else if (len > 0){
                errMsg = msg;
            }
            if (errMsg != '') {
                self.$errorBlock.html(errMsg);
                self.$errorContainer.addClass('has-error');
            } else {
                self.$errorContainer.addClass('has-success');
            }
            if (msg.length == 0) {
                $('#' + idFrom).closest('.has-error').removeClass('has-error').addClass('has-success');
                $('#' + idTo).closest('.has-error').removeClass('has-error').addClass('has-success');
            } else {
                $('#' + idFrom).closest('.has-success').removeClass('has-success').addClass('has-error');
                $('#' + idTo).closest('.has-success').removeClass('has-success').addClass('has-error');
            }
        },
        reset: function () {
            var self = this;
            self.$errorBlock.html('');
            self.$errorContainer.removeClass('has-success has-error');
            self.$mainContainer.removeClass('has-success has-error');
        }
    };

    //Field Range plugin definition
    $.fn.kvFieldRange = function (option) {
        var args = Array.apply(null, arguments);
        args.shift();
        return this.each(function () {
            var $this = $(this),
                data = $this.data('kvFieldRange'),
                options = typeof option === 'object' && option;

            if (!data) {
                $this.data('kvFieldRange', (data = new KvFieldRange(this, $.extend({}, $.fn.kvFieldRange.defaults, options, $(this).data()))));
            }

            if (typeof option === 'string') {
                data[option].apply(data, args);
            }
        });
    };
}(jQuery));