<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-field-range
 * @version 1.3.0
 */

namespace kartik\field;

use yii\base\Model;
use yii\web\View;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\base\Config;
use kartik\form\ActiveForm;
use yii\base\InvalidConfigException;

/**
 * Easily manage Yii 2 ActiveField ranges (from/to) with
 * Bootstrap 3 addons markup
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class FieldRange extends \yii\base\Widget
{
    /**
     * @var ActiveForm the form instance, if used with active form
     */
    public $form;

    /**
     * @var Model the data model that this widget is associated with.
     */
    public $model;

    /**
     * @var string the input types for the field (must be one of the [[INPUT]] constants.
     * Defaults to [[FieldRange::INPUT_TEXT]].
     */
    public $type = self::INPUT_TEXT;

    /**
     * @var string the widget class to use if type is [[FieldRange::INPUT_WIDGET]]
     */
    public $widgetClass;

    /**
     * @var string the label to be displayed. Positioning of the label can be controlled by
     * the [[$template]] property.
     */
    public $label = '';

    /**
     * @var array HTML attributes for the label
     */
    public $labelOptions;

    /**
     * @var string the template to render the widget. The following special tags will be replaced:
     * - `{label}`: will be replaced by the [[$label]] property
     * - `{widget}`: will be replaced by the range widget markup
     * - `{error}`: the common error block for the widget.
     */
    public $template = '{label}{widget}{error}';

    /**
     * @var string the field separator string between first and second field
     */
    public $separator = '&larr; to &rarr;';

    /**
     * @var bool whether to use bootstrap 3 addons using `\kartik\form\ActiveField`
     * If set to `true`, the form instance must be based on `\kartik\form\ActiveForm`.
     * If set to `false` you can use your own widget based on `\yii\widgets\ActiveForm`.
     * Defaults to `true`.
     */
    public $useAddons = true;

    /**
     * @var string the first field's model attribute that this widget is associated with.
     */
    public $attribute1;

    /**
     * @var array the active field configuration for attribute1
     * (applicable when [[$form]] property is set)
     * @see \kartik\form\ActiveField
     */
    public $fieldConfig1 = [];

    /**
     * @var string the first field's input name. This must be set if [[model]] and [[attribute1]] are not set.
     */
    public $name1;

    /**
     * @var string the first field's input value.
     */
    public $value1;

    /**
     * @var array the option data items for first field if [[$type]] is dropDownList, listBox,
     * checkBoxList, or radioList.
     * @see \yii\helpers\Html::dropDownList() for details on how this is to be rendered.
     */
    public $items1 = [];

    /**
     * @var array the HTML attributes for the first field's input tag.
     */
    public $options1 = [];

    /**
     * @var array the widget options for the first field if [[$type]] is [[FieldRange::INPUT_WIDGET]] or one of the
     * inputs from '\kartik\widgets'.
     */
    public $widgetOptions1 = [];

    /**
     * @var string the second field's model attribute that this widget is associated with.
     */
    public $attribute2;

    /**
     * @var array the active field configuration for attribute2
     * (applicable when [[$form]] property is set)
     * @see \kartik\form\ActiveField
     */
    public $fieldConfig2 = [];

    /**
     * @var string the second field's input name. This must be set if [[model]] and [[attribute2]] are not set.
     */
    public $name2;

    /**
     * @var string the second field's input value.
     */
    public $value2;

    /**
     * @var array the option data items for second field if [[$type]] is dropDownList, listBox,
     * checkBoxList, or radioList.
     * @see \yii\helpers\Html::dropDownList() for details on how this is to be rendered.
     */
    public $items2 = [];

    /**
     * @var array the HTML attributes for the second field's input tag.
     */
    public $options2 = [];

    /**
     * @var array the widget options for the second field if [[$type]] is [[FieldRange::INPUT_WIDGET]] or one of the
     * inputs from '\kartik\widgets'.
     */
    public $widgetOptions2 = [];

    /**
     * @var array the HTML attributes for the generated widget input. This has the `input-group` CSS class set by default.
     */
    public $options = [];

    /**
     * @var array the HTML attributes for the widget container
     */
    public $widgetContainer = [];

    /**
     * @var array the HTML attributes for the common error block container
     */
    public $errorContainer = [];

    // input types
    const INPUT_TEXT = 'textInput';
    const INPUT_PASSWORD = 'passwordInput';
    const INPUT_TEXTAREA = 'textArea';
    const INPUT_CHECKBOX = 'checkbox';
    const INPUT_RADIO = 'radio';
    const INPUT_LIST_BOX = 'listBox';
    const INPUT_DROPDOWN_LIST = 'dropDownList';
    const INPUT_CHECKBOX_LIST = 'checkboxList';
    const INPUT_RADIO_LIST = 'radioList';
    const INPUT_FILE = 'fileInput';
    const INPUT_HTML5_INPUT = 'input';
    const INPUT_WIDGET = 'widget';

    // input widget classes
    const INPUT_DEPDROP = '\kartik\widgets\DepDrop';
    const INPUT_SELECT2 = '\kartik\widgets\Select2';
    const INPUT_TYPEAHEAD = '\kartik\widgets\Typeahead';
    const INPUT_SWITCH = '\kartik\widgets\SwitchInput';
    const INPUT_SPIN = '\kartik\widgets\TouchSpin';
    const INPUT_STAR = '\kartik\widgets\StarRating';
    const INPUT_DATE = '\kartik\widgets\DatePicker';
    const INPUT_TIME = '\kartik\widgets\TimePicker';
    const INPUT_DATETIME = '\kartik\widgets\DateTimePicker';
    const INPUT_RANGE = '\kartik\widgets\RangeInput';
    const INPUT_COLOR = '\kartik\widgets\ColorInput';
    const INPUT_RATING = '\kartik\widgets\StarRating';
    const INPUT_FILEINPUT = '\kartik\widgets\FileInput';

    private static $_inputsList = [
        self::INPUT_TEXT => 'textInput',
        self::INPUT_PASSWORD => 'passwordInput',
        self::INPUT_TEXTAREA => 'textArea',
        self::INPUT_CHECKBOX => 'checkbox',
        self::INPUT_RADIO => 'radio',
        self::INPUT_LIST_BOX => 'listBox',
        self::INPUT_DROPDOWN_LIST => 'dropDownList',
        self::INPUT_CHECKBOX_LIST => 'checkboxList',
        self::INPUT_RADIO_LIST => 'radioList',
        self::INPUT_HTML5_INPUT => 'input',
        self::INPUT_FILE => 'fileInput',
        self::INPUT_WIDGET => 'widget',
    ];

    private static $_inputWidgets = [
        self::INPUT_DEPDROP => '\kartik\widgets\DepDrop',
        self::INPUT_SELECT2 => '\kartik\widgets\Select2',
        self::INPUT_TYPEAHEAD => '\kartik\widgets\Typeahead',
        self::INPUT_SWITCH => '\kartik\widgets\SwitchInput',
        self::INPUT_SPIN => '\kartik\widgets\TouchSpin',
        self::INPUT_STAR => '\kartik\widgets\StarRating',
        self::INPUT_DATE => '\kartik\widgets\DatePicker',
        self::INPUT_TIME => '\kartik\widgets\TimePicker',
        self::INPUT_DATETIME => '\kartik\widgets\DateTimePicker',
        self::INPUT_RANGE => '\kartik\widgets\RangeInput',
        self::INPUT_COLOR => '\kartik\widgets\ColorInput',
        self::INPUT_RATING => '\kartik\widgets\StarRating',
        self::INPUT_FILEINPUT => '\kartik\widgets\FileInput',
    ];

    private static $_dropDownInputs = [
        self::INPUT_LIST_BOX => 'listBox',
        self::INPUT_DROPDOWN_LIST => 'dropDownList',
        self::INPUT_CHECKBOX_LIST => 'checkboxList',
        self::INPUT_RADIO_LIST => 'radioList',

    ];

    /**
     * @var bool whether the field is a normal HTML Input rendered by yii\helpers\Html
     */
    private $_isInput = false;

    /**
     * @var bool whether the field is a dropdown input
     */
    private $_isDropdown = false;

    /**
     * @var array the HTML options for the main container
     */
    public $container = [];

    private $_isHorizontalForm = false;

    /**
     * Initializes the widget
     */
    public function init()
    {
        parent::init();
        $this->_isHorizontalForm = $this->form instanceof ActiveForm && !empty($this->form->type) && $this->form->type == ActiveForm::TYPE_HORIZONTAL;
        if ($this->_isHorizontalForm) {
            $this->fieldConfig1['showLabels'] = false;
            $this->fieldConfig2['showLabels'] = false;
        }
        $this->_isInput = in_array($this->type, self::$_inputsList) && $this->type !== self::INPUT_WIDGET;
        $this->_isDropdown = in_array($this->type, self::$_dropDownInputs);
        $this->validateSettings();
        $this->initOptions();
        $this->registerAssets();
    }

    /**
     * Runs the widget
     *
     * @return string|void
     */
    public function run()
    {
        parent::run();
        $this->renderWidget();
    }

    protected function renderWidget()
    {
        if ($this->_isHorizontalForm) {
            $style = $this->form->getFormLayoutStyle();
            Html::addCssClass($this->labelOptions, $style['labelCss']);
            Html::addCssClass($this->widgetContainer, $style['inputCss']);
            Html::addCssClass($this->errorContainer, $style['offsetCss']);
        }
        if ($this->type === self::INPUT_DATE) {
            $widget = $this->getDatePicker();
        } else {
            Html::addCssClass($this->container, 'form-group');
            Html::addCssClass($this->options, 'input-group');
            $widget = isset($this->form) ? $this->getFormInput() : $this->getInput(1) .
                '<span class="input-group-addon kv-field-separator">' . $this->separator . '</span>' .
                $this->getInput(2);
            $widget = Html::tag('div', $widget, $this->options);
        }
        $widget = Html::tag('div', $widget, $this->widgetContainer);
        $error = Html::tag('div', '<div class="help-block"></div>', $this->errorContainer);

        echo Html::tag('div', strtr($this->template, [
            '{label}' => Html::label($this->label, null, $this->labelOptions),
            '{widget}' => $widget,
            '{error}' => $error
        ]), $this->container);
    }

    public function validateSettings()
    {
        if (!$this->hasModel() && ($this->name1 === null || $this->name2 === null)) {
            throw new InvalidConfigException("Either 'name1','name2' or 'attribute1', 'attribute2' with 'model' properties must be specified.");
        }
        if (!$this->_isInput && $this->type !== self::INPUT_WIDGET && !in_array($this->type, self::$_inputWidgets)) {
            throw new InvalidConfigException("Invalid value for 'type'. Must be one of the FieldRange::INPUT constants.");
        }
        if (isset($this->form) && $this->useAddons && !$this->form instanceof ActiveForm) {
            Config::checkDependency('form\ActiveForm', ['yii2-widget-activeform', 'yii2-widgets'], "when 'useAddons' is set to true.");
            throw new InvalidConfigException("The 'form' property must be an instance of '\\kartik\\form\\ActiveForm' or '\\kartik\\widgets\\ActiveForm' when 'useAddons' is set to true.");
        }
        if (isset($this->form) && !$this->useAddons && !$this->form instanceof \yii\widgets\ActiveForm) {
            throw new InvalidConfigException("The 'form' property must be an instance of '\\yii\\widgets\\ActiveForm'.");
        }
        if (isset($this->form) && !$this->hasModel()) {
            throw new InvalidConfigException("The 'model' and 'attribute1', 'attribute2' property must be set when 'form' is set.");
        }
        if ($this->type === self::INPUT_WIDGET && empty($this->widgetClass)) {
            throw new InvalidConfigException("The 'widgetClass' property must be set for widget input type.");
        }
    }

    public function initOptions()
    {
        Html::addCssClass($this->labelOptions, 'control-label');
        if (in_array($this->type, self::$_inputWidgets)) {
            $this->widgetClass = $this->type;
        }
        if ($this->_isInput && empty($this->options1['class'])) {
            Html::addCssClass($this->options1, 'form-control');
        }
        if ($this->_isInput && empty($this->options2['class'])) {
            Html::addCssClass($this->options2, 'form-control');
        }
        if (empty($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        if (empty($this->options1['id'])) {
            $this->options1['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute1) : $this->options['id'] . '-1';
        }
        if (empty($this->options2['id'])) {
            $this->options2['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute2) : $this->options['id'] . '-2';
        }
        if (empty($this->errorContainer['id'])) {
            $this->errorContainer['id'] = $this->options1['id'] . '-error';
        }
        $this->container['id'] = $this->options['id'] . '-container';
    }

    /**
     * Generate the input markup for DatePicker widget
     *
     * @return string the date picker range input
     */
    protected function getDatePicker()
    {
        $class = self::INPUT_DATE;
        $this->widgetOptions1['type'] = $class::TYPE_RANGE;
        $this->widgetOptions1['separator'] = $this->separator;
        if ($this->hasModel()) {
            $this->widgetOptions1 = ArrayHelper::merge($this->widgetOptions1, [
                'model' => $this->model,
                'attribute' => $this->attribute1,
                'attribute2' => $this->attribute2,
                'options' => $this->options,
                'options2' => $this->options2,
            ]);
        } else {
            $this->widgetOptions1 = ArrayHelper::merge($this->widgetOptions1, [
                'name' => $this->name1,
                'name2' => $this->name2,
                'value' => isset($this->value1) ? $this->value1 : null,
                'value2' => isset($this->value2) ? $this->value2 : null,
                'options' => $this->options1,
                'options2' => $this->options2,
            ]);
        }
        if (isset($this->form)) {
            $this->widgetOptions1['form'] = $this->form;
        }
        return $class::widget($this->widgetOptions1);
    }

    /**
     * Generate the input markup for ActiveForm input
     *
     * @return string the form input markup
     */
    protected function getFormInput()
    {
        Html::addCssClass($this->options, 'input-group');
        $fieldType = $this->type;
        $options1 = ArrayHelper::getValue($this->fieldConfig1, 'options', []);
        $options2 = ArrayHelper::getValue($this->fieldConfig2, 'options', []);
        Html::addCssClass($options1, 'kv-container-from form-control');
        Html::addCssClass($options2, 'kv-container-to form-control');
        $this->fieldConfig1 = ArrayHelper::merge($this->fieldConfig1, ['template' => '{input}{error}', 'options' => $options1]);
        $this->fieldConfig2 = ArrayHelper::merge($this->fieldConfig2, ['template' => '{input}{error}', 'options' => $options2]);
        Html::addCssClass($this->options1, 'form-control kv-field-from');
        Html::addCssClass($this->options2, 'form-control kv-field-to');
        $field1 = $this->form->field($this->model, $this->attribute1, $this->fieldConfig1);
        $field2 = $this->form->field($this->model, $this->attribute2, $this->fieldConfig2);
        if ($this->type === self::INPUT_HTML5_INPUT) {
            $input1 = $field1->$fieldType(ArrayHelper::remove($this->options1, 'type', 'text'), $this->options1);
            $input2 = $field2->$fieldType(ArrayHelper::remove($this->options2, 'type', 'text'), $this->options2);

        } elseif ($this->_isDropdown) {
            $input1 = $field1->$fieldType($this->items1, $this->options1);
            $input2 = $field2->$fieldType($this->items2, $this->options2);
        } elseif ($this->_isInput) {
            $input1 = $field1->$fieldType($this->options1);
            $input2 = $field2->$fieldType($this->options2);
        } else {
            $this->setWidgetOptions(1);
            $this->setWidgetOptions(2);
            $input1 = $field1->widget($this->widgetClass, $this->widgetOptions1);
            $input2 = $field2->widget($this->widgetClass, $this->widgetOptions2);

        }
        return $input1 . '<span class="input-group-addon kv-field-separator">' . $this->separator . '</span>' . $input2;
    }

    /**
     * Generate the input markup for non ActiveForm input
     *
     * @param int $i the input serial number
     * @return string the input markup
     */
    protected function getInput($i)
    {
        $name = "name{$i}";
        $value = "value{$i}";
        $attribute = "attribute{$i}";
        $items = "items{$i}";
        $options = "options{$i}";
        $widgetOptions = "widgetOptions{$i}";
        $fieldType = $this->type;

        if (!$this->_isInput) {
            $class = $this->widgetClass;
            $this->setWidgetOptions($i);
            return $class::widget($this->$widgetOptions);
        }

        $param1 = $this->$name;
        $param2 = $this->$value;

        if ($this->hasModel()) {
            $fieldType = 'active' . ucfirst($fieldType);
            $param1 = $this->model;
            $param2 = $this->$attribute;
        }

        if ($this->type === self::INPUT_HTML5_INPUT) {
            return Html::$fieldType(ArrayHelper::remove($this->$options, 'type', 'text'), $param1, $param2, $this->$options);
        }

        return $this->_isDropdown ?
            Html::$fieldType($param1, $param2, $this->$items, $this->$options) :
            Html::$fieldType($param1, $param2, $this->$options);
    }

    /**
     * Sets widget options
     *
     * @param int $i the field seq num
     */
    protected function setWidgetOptions($i)
    {
        $name = "name{$i}";
        $value = "value{$i}";
        $attribute = "attribute{$i}";
        $options = "options{$i}";
        $widgetOptions = "widgetOptions{$i}";
        if ($this->hasModel()) {
            $this->$widgetOptions = ArrayHelper::merge($this->$widgetOptions, [
                'model' => $this->model,
                'attribute' => $this->$attribute,
                'options' => $this->$options
            ]);
        } else {
            $this->$widgetOptions = ArrayHelper::merge($this->$widgetOptions, [
                'name' => $this->$name,
                'value' => $this->$value,
                'options' => $this->$options
            ]);
        }
    }

    /**
     * Registers client assets
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        $name = 'kvFieldRange';
        FieldRangeAsset::register($view);
        $id = '$("#' . $this->options2['id'] . '")';
        $options = Json::encode([
            'attrFrom' => $this->options1['id'],
            'container' => $this->container['id'],
            'errorContainer' => $this->errorContainer['id'],
        ]);
        $hashVar = $name . '_' . hash('crc32', $options);
        $this->options['data-krajee-'.$name] = $hashVar;
        $view->registerJs("var {$hashVar} = {$options};\n", View::POS_HEAD);
        $view->registerJs("{$id}.{$name}({$hashVar});");
    }

    /**
     * @return boolean whether this widget is associated with a data model.
     */
    protected function hasModel()
    {
        return $this->model instanceof Model && $this->attribute1 !== null && $this->attribute2 !== null;
    }

}