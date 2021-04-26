<?php

namespace App\Original\Util;

class VIewTagUtil {

	// タグ全般の要素の変数
    public $id;
    public $name;
    public $value;
    public $defaultValue;

    // selectタグの要素の変数
    public $isEmptyRow;
    public $options;
    public $isMulti = false;

    public function __construct( $id=null, $name=null, $value=null ) {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    ######################
    ## タグ全般用のメソッド
    ######################

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
    }

    public function getDefaultValue() {
        return $this->defaultValue;
    }

    public function setDefaultValue($value) {
        $this->defaultValue = $value;
    }

    ######################
    ## selectタグ用のメソッド
    ######################

    public function setEmptyRow($value) {
        return $this->isEmptyRow = $value;
    }

    public function isEmptyRow() {
        return $this->isEmptyRow;
    }

    public function setOptions($values) {
        $this->options = $values;
    }

    public function getOptions() {
        return $this->options;
    }

    public function setMulti($value) {
        $this->isMulti = $value;
    }

    public function isMulti() {
        return $this->isMulti;
    }
}
