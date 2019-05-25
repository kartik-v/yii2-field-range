<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2018
 * @package yii2-field-range
 * @version 1.3.5
 */

namespace kartik\field;

use Exception;
use kartik\base\Config;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\helpers\Html;
use yii\base\InvalidConfigException;
use yii\base\Model;
use kartik\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\View;

/**
 * FieldRange widget enables to setup and manage an input field range (from/to values) that works seamlessly with
 * [[ActiveForm]] and [[\kartik\form\ActiveField]].
 *
 * The widget renders the range feature by implementing styling available with
 * - [Bootstrap 3 input group addons](http://getbootstrap.com/components/#input-groups) for [[bsVersion]] = `3.x`
 * - [Bootstrap 4 input group addons](http://getbootstrap.com/components/#input-groups) for [[bsVersion]] = `4.x`
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class FieldRange extends Widget
{
    /**
     * Input type rendered via [[Html::textInput]]
     */
    const INPUT_TEXT = 'textInput';
    /**
     * Input type rendered via [[Html::passwordInput()]]
     */
    const INPUT_PASSWORD = 'passwordInput';
    /**
     * Input type rendered via [[Html::textarea()]]
     */
    const INPUT_TEXTAREA = 'textarea';
    /**
     * Input type rendered via [[Html::checkbox()]]
     */
    const INPUT_CHECKBOX = 'checkbox';
    /**
     * Input type rendered via [[Html::radio()]]
     */
    const INPUT_RADIO = 'radio';
    /**
     * Input type rendered via [[Html::listBox()]]
     */
    const INPUT_LIST_BOX = 'listBox';
    /**
     * Input type rendered via [[Html::dropDownList()]]
     */
    const INPUT_DROPDOWN_LIST = 'dropDownList';
    /**
     * Input type rendered via [[Html::checkboxList()]]
     */
    const INPUT_CHECKBOX_LIST = 'checkboxList';
    /**
     * Input type rendered via [[Html::radioList()]]
     */
    const INPUT_RADIO_LIST = 'radioList';
    /**
     * Input type rendered via [[Html::checkboxButtonGroup()]]
     */
    const INPUT_CHECKBOX_BUTTON_GROUP = 'checkboxButtonGroup';
    /**
     * Input type rendered via [[Html::radioButtonGroup()]]
     */
    const INPUT_RADIO_BUTTON_GROUP = 'radioButtonGroup';
    /**
     * Input type rendered via [[Html::fileInput()]]
     */
    const INPUT_FILE = 'fileInput';
    /**
     * Input type rendered via [[Html::input()]]
     */
    const INPUT_HTML5_INPUT = 'input';
    /**
     * Input type rendered via [[Widget]]
     */
    const INPUT_WIDGET = 'widget';
    /**
     * Krajee Dependent Dropdown widget [[\kartik\depdrop\DepDrop]]
     */
    const INPUT_DEPDROP = '\kartik\depdrop\DepDrop';
    /**
     * Krajee Checkbox Extended widget [[\kartik\checkbox\CheckboxX]]
     */
    const INPUT_CHECKBOXX = '\kartik\checkbox\CheckboxX';
    /**
     * Krajee Select2 widget [[\kartik\select2\Select2]]
     */
    const INPUT_SELECT2 = '\kartik\select2\Select2';
    /**
     * Krajee Typeahead widget [[\kartik\typeahead\Typeahead]]
     */
    const INPUT_TYPEAHEAD = '\kartik\typeahead\Typeahead';
    /**
     * Krajee SwitchInput widget [[\kartik\switchinput\SwitchInput]]
     */
    const INPUT_SWITCH = '\kartik\switchinput\SwitchInput';
    /**
     * Krajee TouchSpin widget [[\kartik\touchspin\TouchSpin]]
     */
    const INPUT_SPIN = '\kartik\touchspin\TouchSpin';
    /**
     * Krajee StarRating widget [[\kartik\rating\StarRating]]
     */
    const INPUT_RATING = '\kartik\rating\StarRating';
    /**
     * Krajee DatePicker widget [[\kartik\date\DatePicker]]
     */
    const INPUT_DATE = '\kartik\date\DatePicker';
    /**
     * Krajee TimePicker widget [[\kartik\time\TimePicker]]
     */
    const INPUT_TIME = '\kartik\time\TimePicker';
    /**
     * Krajee DateTimePicker widget [[\kartik\datetime\DateTimePicker]]
     */
    const INPUT_DATETIME = '\kartik\datetime\DateTimePicker';
    /**
     * Krajee Mask Money widget [[\kartik\money\MaskMoney]]
     */
    const INPUT_MONEY = '\kartik\money\MaskMoney';
    /**
     * Krajee Sortable Input widget [[\kartik\sortinput\SortableInput]]
     */
    const INPUT_SORTABLE = '\kartik\sortinput\SortableInput';
    /**
     * Krajee Treeview Input widget [[\kartik\tree\TreeViewInput]]
     */
    const INPUT_TREEVIEW = '\kartik\tree\TreeViewInput';
    /**
     * Krajee RangeInput widget [[\kartik\range\RangeInput]]
     */
    const INPUT_RANGE = '\kartik\range\RangeInput';
    /**
     * Krajee ColorInput widget [[\kartik\color\ColorInput]]
     */
    const INPUT_COLOR = '\kartik\color\ColorInput';
    /**
     * Krajee FileInput widget [[\kartik\file\FileInput]]
     */
    const INPUT_FILE_WIDGET = '\kartik\file\FileInput';
    /**
     * @var array the list of valid inputs
     */
    private static $_inputsList = [
        self::INPUT_TEXT => self::INPUT_TEXT,
        self::INPUT_PASSWORD => self::INPUT_PASSWORD,
        self::INPUT_TEXTAREA => self::INPUT_TEXTAREA,
        self::INPUT_CHECKBOX => self::INPUT_CHECKBOX,
        self::INPUT_RADIO => self::INPUT_RADIO,
        self::INPUT_LIST_BOX => self::INPUT_LIST_BOX,
        self::INPUT_DROPDOWN_LIST => self::INPUT_DROPDOWN_LIST,
        self::INPUT_CHECKBOX_LIST => self::INPUT_CHECKBOX_LIST,
        self::INPUT_RADIO_LIST => self::INPUT_RADIO_LIST,
        self::INPUT_CHECKBOX_BUTTON_GROUP => self::INPUT_CHECKBOX_BUTTON_GROUP,
        self::INPUT_RADIO_BUTTON_GROUP => self::INPUT_RADIO_BUTTON_GROUP,
        self::INPUT_HTML5_INPUT => self::INPUT_HTML5_INPUT,
        self::INPUT_FILE => self::INPUT_FILE,
        self::INPUT_WIDGET => self::INPUT_WIDGET,
    ];
    /**
     * @var array the list of valid input widgets
     */
    private static $_inputWidgets = [
        self::INPUT_DEPDROP => self::INPUT_DEPDROP,
        self::INPUT_CHECKBOXX => self::INPUT_CHECKBOXX,
        self::INPUT_SELECT2 => self::INPUT_SELECT2,
        self::INPUT_TYPEAHEAD => self::INPUT_TYPEAHEAD,
        self::INPUT_SWITCH => self::INPUT_SWITCH,
        self::INPUT_SPIN => self::INPUT_SPIN,
        self::INPUT_RATING => self::INPUT_RATING,
        self::INPUT_DATE => self::INPUT_DATE,
        self::INPUT_TIME => self::INPUT_TIME,
        self::INPUT_DATETIME => self::INPUT_DATETIME,
        self::INPUT_MONEY => self::INPUT_MONEY,
        self::INPUT_RANGE => self::INPUT_RANGE,
        self::INPUT_COLOR => self::INPUT_COLOR,
        self::INPUT_FILE_WIDGET => self::INPUT_FILE_WIDGET,
    ];
    /**
     * @var array the list of valid dropdown inputs
     */
    private static $_dropDownInputs = [
        self::INPUT_LIST_BOX => self::INPUT_LIST_BOX,
        self::INPUT_DROPDOWN_LIST => self::INPUT_DROPDOWN_LIST,
        self::INPUT_CHECKBOX_LIST => self::INPUT_CHECKBOX_LIST,
        self::INPUT_RADIO_LIST => self::INPUT_RADIO_LIST,
        self::INPUT_CHECKBOX_BUTTON_GROUP => self::INPUT_CHECKBOX_BUTTON_GROUP,
        self::INPUT_RADIO_BUTTON_GROUP => self::INPUT_RADIO_BUTTON_GROUP,
    ];
    /**
     * @var ActiveForm the form instance, if used with active form
     */
    public $form;
    /**
     * @var Model the data model that this widget is associated with.
     */
    public $model;
    /**
     * @var string the input types for the field (must be one of the `kartik\field\FieldRange::INPUT_XXX` constants.
     */
    public $type = self::INPUT_TEXT;
    /**
     * @var string the widget class to use if [[type]] is set to [[INPUT_WIDGET]].
     */
    public $widgetClass;
    /**
     * @var string the label to be displayed. Positioning of the label can be controlled by the [[template]] property.
     */
    public $label = '';
    /**
     * @var array HTML attributes for the label.
     */
    public $labelOptions = [];
    /**
     * @var string the template to render the widget.
     *
     * The following special tokens will be replaced:
     * - `{label}`: will be replaced by the [[label]] property
     * - `{widget}`: will be replaced by the range widget markup
     * - `{error}`: the common error block for the widget.
     */
    public $template = '{label}{widget}{error}';
    /**
     * @var string the field separator string between first and second field
     */
    public $separator = '&larr; to &rarr;';
    /**
     * @var array HTML attributes for the separator. The following array keys are specially identified:
     *
     * - `tag`: _string_, the HTML tag used to render the separator container. Defaults to `span`.
     *
     * Defaults to:
     * - `['class' => 'input-group-addon']` for [[bsVersion]] = `3.x`
     * - `['class' => 'input-group-text']` for [[bsVersion]] = `4.x`
     */
    public $separatorOptions = [];
    /**
     * @var boolean whether to implement and render bootstrap 3 addons using [[\kartik\form\ActiveField]].
     *
     * - if set to `true`, the form instance must be based on [[ActiveForm]].
     * - if set to `false` you can use your own widget based on [[\yii\widgets\ActiveForm]].
     */
    public $useAddons = true;

    /**
     * @var string the additional CSS class that will be appended to input markup
     */
    public $addInputCss = 'form-control';

    /**
     * @var string the first field's model attribute that this widget is associated with.
     */
    public $attribute1;
    /**
     * @var array the active field configuration for attribute1 (applicable when [[form]] property is set).
     * @see [[\kartik\form\ActiveField]]
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
     * @var array the option data items for first field if [[type]] is set to [[INPUT_DROPDOWN_LIST]], [[INPUT_LIST_BOX]],
     * [[INPUT_CHECKBOX_LIST]], [[INPUT_RADIO_LIST]], [[INPUT_CHECKBOX_BUTTON_GROUP]], [[INPUT_RADIO_BUTTON_GROUP]].
     *
     * @see [[\yii\helpers\Html::dropDownList()]] for details on how this is to be rendered.
     */
    public $items1 = [];
    /**
     * @var array the HTML attributes for the first field's input tag.
     */
    public $options1 = [];
    /**
     * @var array the widget options for the first field if [[type]] is [[INPUT_WIDGET]] or one of the Krajee input
     * inputs from `\kartik\widgets`.
     */
    public $widgetOptions1 = [];
    /**
     * @var string the second field's model attribute that this widget is associated with.
     */
    public $attribute2;
    /**
     * @var array the active field configuration for attribute2 (applicable when [[form]] property is set)
     * @see [[\kartik\form\ActiveField]]
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
     * @var array the option data items for second fieldif [[type]] is set to [[INPUT_DROPDOWN_LIST]], [[INPUT_LIST_BOX]],
     * [[INPUT_CHECKBOX_LIST]], [[INPUT_RADIO_LIST]], [[INPUT_CHECKBOX_BUTTON_GROUP]], [[INPUT_RADIO_BUTTON_GROUP]].
     *
     * @see [[\yii\helpers\Html::dropDownList()]] for details on how this is to be rendered.
     */
    public $items2 = [];
    /**
     * @var array the HTML attributes for the second field's input tag.
     */
    public $options2 = [];
    /**
     * @var array the widget options for the second field if [[type]] is [[INPUT_WIDGET]] or one of the
     * inputs from `\kartik\widgets`.
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
    /**
     * @var array the HTML options for the main container
     */
    public $container = [];
    /**
     * @var boolean whether the field is a normal HTML Input rendered by yii\helpers\Html
     */
    private $_isInput = false;
    /**
     * @var boolean whether the field is a dropdown input
     */
    private $_isDropdown = false;
    /**
     * @var boolean whether it the form is of bootstrap horizontal layout style.
     */
    private $_isHorizontalForm = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->_isHorizontalForm = $this->form instanceof ActiveForm && !empty($this->form->type) && $this->form->type == ActiveForm::TYPE_HORIZONTAL;
        if ($this->_isHorizontalForm) {
            $this->fieldConfig1['showLabels'] = false;
            $this->fieldConfig2['showLabels'] = false;
        }
        $this->_isInput = isset(self::$_inputsList[$this->type]) && $this->type !== self::INPUT_WIDGET;
        $this->_isDropdown = isset(self::$_dropDownInputs[$this->type]);
        $this->validateSettings();
        $this->initOptions();
        $this->registerAssets();
    }

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function run()
    {
        parent::run();
        $this->renderWidget();
    }

    /**
     * Validates the widget settings.
     *
     * @throws InvalidConfigException
     */
    public function validateSettings()
    {
        if (!$this->hasModel() && ($this->name1 === null || $this->name2 === null)) {
            throw new InvalidConfigException(
                "Either 'name1','name2' or 'attribute1', 'attribute2' with 'model' properties must be specified."
            );
        }
        if (!$this->_isInput && $this->type !== self::INPUT_WIDGET && !isset(self::$_inputWidgets[$this->type])) {
            throw new InvalidConfigException(
                "Invalid value for 'type'. Must be one of the FieldRange::INPUT constants."
            );
        }
        if (isset($this->form) && $this->useAddons && !$this->form instanceof ActiveForm) {
            Config::checkDependency(
                'form\ActiveForm', ['yii2-widget-activeform', 'yii2-widgets'], "when 'useAddons' is set to true."
            );
            throw new InvalidConfigException(
                "The 'form' property must be an instance of '\\kartik\\form\\ActiveForm' or '\\kartik\\widgets\\ActiveForm' when 'useAddons' is set to true."
            );
        }
        if (isset($this->form) && !$this->useAddons && !$this->form instanceof \yii\widgets\ActiveForm) {
            throw new InvalidConfigException(
                "The 'form' property must be an instance of '\\yii\\widgets\\ActiveForm'."
            );
        }
        if (isset($this->form) && !$this->hasModel()) {
            throw new InvalidConfigException(
                "The 'model' and 'attribute1', 'attribute2' property must be set when 'form' is set."
            );
        }
        if ($this->type === self::INPUT_WIDGET && empty($this->widgetClass)) {
            throw new InvalidConfigException("The 'widgetClass' property must be set for widget input type.");
        }
    }

    /**
     * Initializes the widget options.
     * @throws InvalidConfigException
     */
    public function initOptions()
    {
        Html::addCssClass($this->labelOptions, ['control-label', 'col-form-label']);
        $css = $this->isBs4() ? 'input-group-text' : 'input-group-addon';
        Html::addCssClass($this->separatorOptions, [$css, 'kv-field-separator']);
        if (isset(self::$_inputWidgets[$this->type])) {
            $this->widgetClass = $this->type;
        }
        if ($this->_isInput) {
            Html::addCssClass($this->options1, $this->addInputCss);
        }
        if ($this->_isInput) {
            Html::addCssClass($this->options2, $this->addInputCss);
        }
        if (empty($this->options1['id'])) {
            $this->options1['id'] = $this->hasModel() ? Html::getInputId(
                $this->model, $this->attribute1
            ) : $this->options['id'] . '-1';
        }
        if (empty($this->options2['id'])) {
            $this->options2['id'] = $this->hasModel() ? Html::getInputId(
                $this->model, $this->attribute2
            ) : $this->options['id'] . '-2';
        }
        if (empty($this->errorContainer['id'])) {
            $this->errorContainer['id'] = $this->options1['id'] . '-error';
        }
        $this->container['id'] = $this->options['id'] . '-container';
    }

    /**
     * Renders the field range widget.
     * @throws InvalidConfigException
     * @throws Exception
     */
    protected function renderWidget()
    {
        Html::addCssClass($this->options, 'kv-field-range');
        Html::addCssClass($this->container, 'kv-field-range-container');
        $isBs4 = $this->isBs4();
        $style = ['labelCss' => 'col-sm-3', 'inputCss' => 'col-sm-9'];
        if ($this->_isHorizontalForm) {
            $style = $this->form->getFormLayoutStyle();
            Html::addCssClass($this->labelOptions, $style['labelCss']);
            Html::addCssClass($this->widgetContainer, $style['inputCss']);
        }
        if ($this->type === self::INPUT_DATE) {
            $widget = $this->getDatePicker();
        } else {
            $css = 'form-group';
            if ($isBs4 && $this->_isHorizontalForm) {
                $css = [$css, 'row'];
            }
            Html::addCssClass($this->container, $css);
            Html::addCssClass($this->options, 'input-group');
            $tag = ArrayHelper::remove($this->separatorOptions, 'tag', 'span');
            $sep = Html::tag($tag, $this->separator, $this->separatorOptions);
            if ($isBs4) {
                $sep = Html::tag('div', $sep, ['class' => 'input-group-append kv-separator-container']);
            }
            $getInput = isset($this->form) ? 'getFormInput' : 'getInput';
            $widget = Html::tag('div', $this->$getInput(1) . $sep . $this->$getInput(2), $this->options);
        }
        $widget = Html::tag('div', $widget, $this->widgetContainer);
        $css = 'help-block';
        if ($this->isBs4()) {
            $css .= ' text-danger';
        }
        $preError = '';
        $errorCss = ['kv-field-range-error'];
        if ($this->_isHorizontalForm) {
            $errorCss[] = $style['inputCss'];
            Html::addCssClass($this->errorContainer, $errorCss);
            $preError = Html::tag('div', '', ['class' => $style['labelCss']]);
        }
        $error = $preError . Html::tag('div', '<div class="' . $css . '"></div>', $this->errorContainer);
        $replaceTokens = [
            '{label}' => Html::label($this->label, null, $this->labelOptions),
            '{widget}' => $widget,
            '{error}' => $error,
        ];
        echo Html::tag('div', strtr($this->template, $replaceTokens), $this->container);
    }

    /**
     * Generate the range input markup for [[DatePicker]] widget.
     *
     * @return string the date picker range input
     * @throws Exception
     */
    protected function getDatePicker()
    {
        /**
         * @var DatePicker $class
         */
        $class = self::INPUT_DATE;
        $this->widgetOptions1['type'] = $class::TYPE_RANGE;
        $this->widgetOptions1['separator'] = $this->separator;
        if ($this->hasModel()) {
            $this->widgetOptions1 = ArrayHelper::merge(
                $this->widgetOptions1,
                [
                    'model' => $this->model,
                    'attribute' => $this->attribute1,
                    'attribute2' => $this->attribute2,
                    'options' => $this->options,
                    'options2' => $this->options2,
                ]
            );
        } else {
            $this->widgetOptions1 = ArrayHelper::merge(
                $this->widgetOptions1,
                [
                    'name' => $this->name1,
                    'name2' => $this->name2,
                    'value' => isset($this->value1) ? $this->value1 : null,
                    'value2' => isset($this->value2) ? $this->value2 : null,
                    'options' => $this->options1,
                    'options2' => $this->options2,
                ]
            );
        }
        if (isset($this->form)) {
            $this->widgetOptions1['form'] = $this->form;
        }
        return $class::widget($this->widgetOptions1);
    }

    /**
     * Generate the input markup for an [[ActiveForm]] input.
     *
     * @param integer $i the input serial number
     *
     * @return string the form input markup
     */
    protected function getFormInput($i)
    {
        Html::addCssClass($this->options, 'input-group');
        $fieldType = $this->type;
        $fieldConfig = "fieldConfig{$i}";
        $options = "options{$i}";
        $attribute = "attribute{$i}";
        $items = "items{$i}";
        $widgetOptions = "widgetOptions{$i}";
        $css1 = $i === 1 ? 'kv-container-from' : 'kv-container-to';
        $css2 = $i === 1 ? 'kv-field-from' : 'kv-field-to';
        $fieldOpts = ArrayHelper::getValue($this->$fieldConfig, 'options', []);
        Html::addCssClass($fieldOpts, $css1);
        Html::addCssClass($fieldOpts, $this->addInputCss);
        $this->$fieldConfig = ArrayHelper::merge(
            $this->$fieldConfig, ['template' => '{input}{error}', 'options' => $fieldOpts]
        );
        Html::addCssClass($this->$options, $css2);
        Html::addCssClass($this->$options, $this->addInputCss);
        $field = $this->form->field($this->model, $this->$attribute, $this->$fieldConfig);
        if ($this->type === self::INPUT_HTML5_INPUT) {
            $input = $field->$fieldType(ArrayHelper::remove($this->$options, 'type', 'text'), $this->$options);
        } elseif ($this->_isDropdown) {
            $input = $field->$fieldType($this->$items, $this->$options);
        } elseif ($this->_isInput) {
            $input = $field->$fieldType($this->$options);
        } else {
            $this->setWidgetOptions($i);
            $input = $field->widget($this->widgetClass, $this->$widgetOptions);
        }
        return $input;
    }

    /**
     * Generate the input markup for a normal input.
     *
     * @param integer $i the input serial number
     *
     * @return string the input markup
     * @throws Exception
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

        /**
         * @var Widget $class
         */
        if (!$this->_isInput) {
            $class = $this->widgetClass;
            $this->setWidgetOptions($i);
            return $class::widget($this->$widgetOptions);
        }

        $param1 = $this->$name;
        $param2 = $this->$value;
        $opts = $this->$options;

        if ($this->hasModel()) {
            $fieldType = 'active' . ucfirst($fieldType);
            $param1 = $this->model;
            $param2 = $this->$attribute;
        }

        if ($this->type === self::INPUT_HTML5_INPUT) {
            return Html::$fieldType(ArrayHelper::remove($opts, 'type', 'text'), $param1, $param2, $opts);
        }

        return $this->_isDropdown ? Html::$fieldType($param1, $param2, $this->$items, $opts) :
            Html::$fieldType($param1, $param2, $opts);
    }

    /**
     * Sets widget options.
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
            $this->$widgetOptions = ArrayHelper::merge(
                $this->$widgetOptions,
                [
                    'model' => $this->model,
                    'attribute' => $this->$attribute,
                    'options' => $this->$options,
                ]
            );
        } else {
            $this->$widgetOptions = ArrayHelper::merge(
                $this->$widgetOptions,
                [
                    'name' => $this->$name,
                    'value' => $this->$value,
                    'options' => $this->$options,
                ]
            );
        }
    }

    /**
     * Registers client assets for [[FieldRange]] widget.
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        $name = 'kvFieldRange';
        FieldRangeAsset::registerBundle($view, $this->bsVersion);
        $id = '$("#' . $this->options2['id'] . '")';
        $options = Json::encode(
            [
                'attrFrom' => $this->options1['id'],
                'container' => $this->container['id'],
                'errorContainer' => $this->errorContainer['id'],
            ]
        );
        $hashVar = $name . '_' . hash('crc32', $options);
        $this->options['data-krajee-' . $name] = $hashVar;
        $view->registerJs("var {$hashVar} = {$options};\n", $this->hashVarLoadPosition);
        $view->registerJs("{$id}.{$name}({$hashVar});");
    }

    /**
     * Checks whether the current widget has a model assigned to it.
     *
     * @return boolean whether this widget is associated with a data model.
     */
    protected function hasModel()
    {
        return $this->model instanceof Model && $this->attribute1 !== null && $this->attribute2 !== null;
    }
}
