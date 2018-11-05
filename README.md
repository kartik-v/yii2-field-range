<h1 align="center">
    <a href="http://demos.krajee.com" title="Krajee Demos" target="_blank">
        <img src="http://kartik-v.github.io/bootstrap-fileinput-samples/samples/krajee-logo-b.png" alt="Krajee Logo"/>
    </a>
    <br>
    yii2-field-range
    <hr>
    <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=DTP3NZQ6G2AYU"
       title="Donate via Paypal" target="_blank">
        <img src="http://kartik-v.github.io/bootstrap-fileinput-samples/samples/donate.png" alt="Donate"/>
    </a>
</h1>

[![Stable Version](https://poser.pugx.org/kartik-v/yii2-field-range/v/stable)](https://packagist.org/packages/kartik-v/yii2-field-range)
[![Unstable Version](https://poser.pugx.org/kartik-v/yii2-field-range/v/unstable)](https://packagist.org/packages/kartik-v/yii2-field-range)
[![License](https://poser.pugx.org/kartik-v/yii2-field-range/license)](https://packagist.org/packages/kartik-v/yii2-field-range)
[![Total Downloads](https://poser.pugx.org/kartik-v/yii2-field-range/downloads)](https://packagist.org/packages/kartik-v/yii2-field-range)
[![Monthly Downloads](https://poser.pugx.org/kartik-v/yii2-field-range/d/monthly)](https://packagist.org/packages/kartik-v/yii2-field-range)
[![Daily Downloads](https://poser.pugx.org/kartik-v/yii2-field-range/d/daily)](https://packagist.org/packages/kartik-v/yii2-field-range)

A Yii 2 extension that allows you to easily setup ActiveField range fields with Bootstrap 3 addons markup and more. This allows you to setup 
the attributes joined together like a single field with a bootstrap addon separating the two. In addition, it enables you to display the field 
validation error messages as one single block instead of separate validation errors for two fields.

> NOTE: 
- The FieldRange validation routine displays only the first error encountered in validation of either of the attributes.
- To understand setting up your model validation rules for the attributes when using this extension, refer [this wiki](http://www.yiiframework.com/wiki/698/model-validation-for-field-ranges-using-yii2-field-range-extension/)

The key features supported by this widget extension are:

- display the two range fields as a single grouped block using Bootstrap 3 addons
- tweak yii active form validation to display validation errors as one single block instead of
  separate error blocks under each field. This allows you to style your field range inputs better 
  for various form layouts. No more misalignment of adjacent fields due to yii validation error messages.
- ability to use any input from yii\helpers or any widget class for rendering the from and to fields.
- enhanced usage with `\kartik\widgets\ActiveField` that allows you to add custom addons to prepend and append to your inputs.
- default support for all widgets under `\kartik\widgets`. Special enhanced support for `\kartik\widgets\DatePicker` 
  to render date ranges.
- ability to use the kartik\datecontrol\DateControl widget which in turn can use any Date or Time widgets.

### Demo
You can see detailed [documentation and demos](http://demos.krajee.com/field-range) on usage of the extension.

## Release Changes

> NOTE: Refer the [CHANGE LOG](https://github.com/kartik-v/yii2-field-range/blob/master/CHANGE.md) for details on changes to various releases.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

> Note: Check the [composer.json](https://github.com/kartik-v/yii2-field-range/blob/master/composer.json) for this extension's requirements and dependencies. 
Read this [web tip /wiki](http://webtips.krajee.com/setting-composer-minimum-stability-application/) on setting the `minimum-stability` settings for your application's composer.json.

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

### FieldRange

```php
use kartik\field\FieldRange;
use kartik\widgets\ActiveForm;
$form = ActiveForm::begin();
echo FieldRange::widget([
    'form' => $form,
    'model' => $model,
    'label' => 'Enter start and end points',
    'attribute1' => 'start_point',
    'attribute2' => 'end_point',
    'type' => FieldRange::INPUT_TEXT,
]);
ActiveForm::end();
```

## License

**yii2-field-range** is released under the BSD-3-Clause License. See the bundled `LICENSE.md` for details.