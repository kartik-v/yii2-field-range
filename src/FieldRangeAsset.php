<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2018
 * @package yii2-field-range
 * @version 1.3.5
 */

namespace kartik\field;

use kartik\base\AssetBundle;

/**
 * Field Range bundle for \kartik\field\FieldRange
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class FieldRangeAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/field-range' . ($this->isBs4() ? '-bs4' : '-bs3')]);
        $this->setupAssets('js', ['js/field-range']);
        parent::init();
    }

}