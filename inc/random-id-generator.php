<?php
class RandomIdGenerator {
  function __construct($options) {
    $this->options = $options;

    $this->usedKeys = array();
  }

  function get() {
    $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    do {
      $r = '';

      for ($j = 0; $j < 4; $j++) {
        $r .= $chars[rand(0, strlen($chars) - 1)];
      }

    } while (in_array($r, $this->usedKeys));

    $this->usedKeys[] = $r;

    return $r;
  }
}
