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
    if (!array_key_exists('prefix', $this->options)) {
      $this->options['prefix'] = '';
    }

    $this->usedKeys = array();
    $this->reservedKeys = array();
  }

  function get() {
    do {
      $r = $this->options['prefix'];

      for ($j = 0; $j < $this->options['length']; $j++) {
        $r .= $this->options['chars'][rand(0, strlen($this->options['chars']) - 1)];
      }

    } while ($this->check($r));

    $this->reservedKeys[] = $r;

    return $r;
  }

  function check($key) {
    if (in_array($key, $this->usedKeys))
      return true;
    if (in_array($key, $this->reservedKeys))
      return true;

    return false;
  }

  function use($key) {
    $this->usedKeys[] = $key;

    if (($p = array_search($key, $this->reservedKeys)) !== false) {
      unset($this->reservedKeys[$p]);
    }
  }

  function addUsedKeys($list) {
    $this->usedKeys = array_merge($this->usedKeys, $list);
  }
}
