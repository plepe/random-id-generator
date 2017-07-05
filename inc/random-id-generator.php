<?php
class RandomIdGenerator {
  function __construct($options) {
    $this->options = $options;

    if (!array_key_exists('chars', $this->options)) {
      $this->options['chars'] = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    if (!array_key_exists('length', $this->options)) {
      $this->options['length'] = 4;
    }

    $this->usedKeys = array();
  }

  function get() {
    do {
      $r = '';

      for ($j = 0; $j < $this->options['length']; $j++) {
        $r .= $this->options['chars'][rand(0, strlen($this->options['chars']) - 1)];
      }

    } while (in_array($r, $this->usedKeys));

    $this->usedKeys[] = $r;

    return $r;
  }
}
