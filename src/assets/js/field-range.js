/*!
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2018
 * @version 1.3.4
 *
 * Client validation extension for the yii2-field-range extension
 * 
 * Author: Kartik Visweswaran
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */
(function ($) {
    "use strict";
    var isArray, setContextCss, KvFieldRange;
    isArray = function (a) {
        return Object.prototype.toString.call(a) === '[object Array]' ||
            Object.prototype.toString.call(a) === '[object Object]';
    };
    setContextCss = function (id, css) {
        var $el = $('#' + id).closest('.' + css), altCss;
        if (!$el.length) {
            return;
        }
        altCss = css === 'has-success' ? 'has-error' : 'has-success';
        $el.removeClass(altCss).addClass(css);
    };
    KvFieldRange = function (element, options) {
        var self = this;
        self.$attrTo = $(element);
        self.$attrFrom = $("#" + options.attrFrom);
        self.$mainContainer = $("#" + options.container);
        self.$errorContainer = $("#" + options.errorContainer);
        self.$contFrom = self.$attrFrom.closest('.kv-container-from');
        self.$contTo = self.$attrTo.closest('.kv-container-to');
        self.$errorBlockFrom = self.$contFrom.find('.help-block');
        self.$errorBlockTo = self.$contTo.find('.help-block');
        self.$errorBlock = self.$errorContainer.find('.help-block');
        self.$form = self.$attrFrom.closest('form');
        self.errorToMsg = "";
        self.init();
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
            self.$form.on('beforeValidateAttribute', function () {
                self.$contFrom.removeClass('has-error');
                self.$contTo.removeClass('has-error');
                self.$errorBlockFrom.removeClass('invalid-feedback');
                self.$errorBlockTo.removeClass('invalid-feedback');
            }).on('afterValidate', function (event, messages) {
                var idFrom = self.$attrFrom.attr('id'), idTo = self.$attrTo.attr('id');
                if (idFrom in messages) {
                    self.validateAttribute(messages[idFrom], idFrom, idTo);
                }
                if (idTo in messages) {
                    self.validateAttribute(messages[idTo], idFrom, idTo);
                }
            }).on('afterValidateAttribute', function (event, attribute, messages) {
                var idFrom = self.$attrFrom.attr('id'), idTo = self.$attrTo.attr('id');
                self.$errorBlock.html('');
                self.$errorContainer.removeClass('has-success has-error invalid-feedback');
                if (attribute.id === idFrom || attribute.id === idTo) {
                    self.validateAttribute(messages, idFrom, idTo);
                }
            });
        },
        validateAttribute: function (msg, idFrom, idTo) {
            var self = this, len = msg.length, errMsg = '';
            if (isArray(msg) && len) {
                errMsg = len === 1 ? msg[0] : msg.join('</li><li>');
            } else {
                if (len > 0) {
                    errMsg = msg;
                }
            }
            if (errMsg) {
                self.$errorBlock.html(errMsg);
                self.$errorContainer.addClass('has-error');
            } else {
                self.$errorContainer.addClass('has-success');
            }
            if (msg && msg.length) {
                setContextCss(idFrom, 'has-error');
                setContextCss(idTo, 'has-error');
            } else {
                setContextCss(idFrom, 'has-success');
                setContextCss(idTo, 'has-success');
            }
        },
        reset: function () {
            var self = this;
            self.$errorBlock.html('');
            self.$errorContainer.removeClass('has-success has-error');
            self.$mainContainer.removeClass('has-success has-error');
        }
    };

    $.fn.kvFieldRange = function (option) {
        var args = Array.apply(null, arguments);
        args.shift();
        return this.each(function () {
            var self = $(this), data = self.data('kvFieldRange'), options = typeof option === 'object' && option;
            if (!data) {
                data = new KvFieldRange(this, $.extend({}, $.fn.kvFieldRange.defaults, options, self.data()));
                self.data('kvFieldRange', data);
            }
            if (typeof option === 'string') {
                data[option].apply(data, args);
            }
        });
    };

    $.fn.kvFieldRange.defaults = {
        attrFrom: '',
        container: '',
        errorContainer: ''
    };

    $.fn.kvFieldRange.Constructor = KvFieldRange;
}(window.jQuery));