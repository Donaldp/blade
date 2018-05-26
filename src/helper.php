<?php

if (!function_exists('validation')) {
  function validation($validation, $value = null) {
    if ($value != null) {
      return $validation[$value][0];
    }
  }
}