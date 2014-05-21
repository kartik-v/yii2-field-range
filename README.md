yii2-field-range
=================

A Yii 2 extension that allows you to easily setup ActiveField range fields with Bootstrap 3 addons markup and more. This allows you to setup 
the attributes joined together like a single field with a bootstrap addon separating the two. In addition, it enables you to display the field 
validation error messages as one single block instead of separate validation errors for two fields.

> NOTE: This extension depends on the [kartik-v/yii2-widgets](https://github.com/kartik-v/yii2-widgets) extension which in turn depends on the 
[yiisoft/yii2-bootstrap](https://github.com/yiisoft/yii2/tree/master/extensions/bootstrap) extension. Check the 
[composer.json](https://github.com/kartik-v/yii2-field-range/blob/master/composer.json) for this extension's requirements and dependencies. 
Note: Yii 2 framework is still in active development, and until a fully stable Yii2 release, your core yii2-bootstrap packages (and its dependencies) 
may be updated when you install or update this extension. You may need to lock your composer package versions for your specific app, and test 
for extension break if you do not wish to auto update dependencies.

### Demo
You can see detailed [documentation](http://demos.krajee.com/field-range) on usage of the extension.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require kartik-v/yii2-field-range "dev-master"
```

or add

```
"kartik-v/yii2-field-range": "dev-master"
```

to the ```require``` section of your `composer.json` file.

## Usage

### field-range

```php
use kartik\fieldrange\FieldRange;
echo FieldRange::widget([
    // options
]); 
```

## License

**yii2-field-range** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.