<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @package yii2-field-range
 * @version 1.3.1
 */

namespace kartik\field;

/**
 * Field Range bundle for \kartik\field\FieldRange
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class FieldRangeAsset extends \kartik\base\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/field-range']);
        $this->setupAssets('js', ['js/field-range']);
        parent::init();
    }

}