/*!
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @version 1.0.0
 *
 * Client validation extension for the yii2-field-range extension
 * 
 * Author: Kartik Visweswaran
 * Copyright: 2014, Kartik Visweswaran, Krajee.com
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */

(function ($) {

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
            self.$form.on('submit.yiiActiveForm', function () {
                setTimeout(function () {
                    self.setError(1);
                    self.setError(2);
                }, 1000);
            });

            self.$form.on('reset.yiiActiveForm', function () {
                setTimeout(function () {
                    self.reset();
                }, 100);
            });
            self.initEvent('blur.yiiActiveForm');
            self.initEvent('change.yiiActiveForm');
            self.initEvent('keyup.yiiActiveForm');
        },
        reset: function () {
            var self = this;
            self.$errorBlock.html('');
            self.$errorContainer.removeClass('has-success').removeClass('has-error');
            self.$mainContainer.removeClass('has-success').removeClass('has-error');
            self.$mainContainer.find('.input-group-btn .btn-default').removeClass('btn-success').removeClass('btn-danger');
        },
        initEvent: function (event) {
            var self = this;
            self.$attrFrom.on(event, function () {
                setTimeout(function () {
                    self.setError(1);
                }, 100);
            });

            self.$attrTo.on(event, function () {
                setTimeout(function () {
                    self.setError(2);
                }, 100);
            });
        },
        setError: function (type) {
            var self = this, msgFrom = self.$errorBlockFrom.html(), msgTo = self.$errorBlockTo.html(),
                msg = (type == 1) ? msgFrom : msgTo;
            self.$errorBlock.html('');
            if (self.$errorBlockFrom.parent().hasClass('has-error') || self.$errorBlockTo.parent().hasClass('has-error')) {
                self.$errorContainer.removeClass('has-success').addClass('has-error');
                self.$mainContainer.removeClass('has-success').addClass('has-error');
                self.$mainContainer.find('.input-group-btn .btn-default').removeClass('btn-success').addClass('btn-danger');
            }
            else if (self.$errorBlockFrom.parent().hasClass('has-success') || self.$errorBlockTo.parent().hasClass('has-success')) {
                self.$errorContainer.removeClass('has-error').addClass('has-success');
                self.$mainContainer.removeClass('has-error').addClass('has-success');
                self.$mainContainer.find('.input-group-btn .btn-default').removeClass('btn-danger').addClass('btn-success');
            }
            if (msg) {
                self.$errorBlock.html(msg);
            }
            else if (type == 1 && msgTo) {
                self.$errorBlock.html(msgTo);
            }
            else if (type == 2 && msgFrom) {
                self.$errorBlock.html(msgFrom);
            }
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