<?php
$allRandomIdGenerators = array();

function getRandomIdGenerator($id) {
  global $allRandomIdGenerators;
  return $allRandomIdGenerators[$id];
}

class RandomIdGenerator {
  function __construct($options) {
    $this->options = $options;

    if (!array_key_exists('id', $this->options)) {
      $this->options['id'] = '';
    }
    $this->id = $this->options['id'];
    if (!array_key_exists('chars', $this->options)) {
      $this->options['chars'] = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    if (!array_key_exists('length', $this->options)) {
      $this->options['length'] = 4;
    }
    if (!array_key_exists('prefix', $this->options)) {
      $this->options['prefix'] = '';
    }
    if (!array_key_exists('db_table', $this->options)) {
      $this->options['db_table'] = '__random_id_generator__';
    }
    if (!array_key_exists('db_timespan', $this->options)) {
      $this->options['db_timespan'] = 3600;
    }
    if (array_key_exists('db', $this->options)) {
      $this->db = $this->options['db'];
    }

    $this->usedKeys = array();
    $this->checkFun = null;

    if (isset($this->db)) {
      $this->initDb();
    }

    global $allRandomIdGenerators;
    $allRandomIdGenerators[$this->id] = $this;
  }

  function initDb() {
    try {
      $res = $this->db->query("select 1 from {$this->options['db_table']}");
    } catch(Exception $e) {
      $res = false;
    }

    if ($res === false) {
      $query = <<<EOT
create table {$this->options['db_table']} (
  generator_id	varchar(255) not null,
  id            varchar(255) not null,
  ts            text,
  primary key(generator_id, id)
);
EOT;
      $this->db->query($query);
    }
    else {
      $res->closeCursor();
    }

    $this->db->query("delete from {$this->options['db_table']} where ts<" . $this->db->quote(Date('Y-m-d H:i:s')));
  }

  function get() {
    do {
      $r = $this->options['prefix'];

      for ($j = 0; $j < $this->options['length']; $j++) {
        $r .= $this->options['chars'][rand(0, strlen($this->options['chars']) - 1)];
      }

    } while ($this->check($r));

    $this->usedKeys[] = $r;

    if (isset($this->db)) {
      $db_timeout = Date('Y-m-d H:i:s', time() + $this->options['db_timespan']);
      $res = $this->db->query("insert into {$this->options['db_table']} values (" . $this->db->quote($this->id) . ", " . $this->db->quote($r) . ", " . $this->db->quote($db_timeout) . ")");
    }

    return $r;
  }

  function check($key, $global=true) {
    if (in_array($key, $this->usedKeys))
      return true;

    if (isset($this->db)) {
      $res = $this->db->query("select * from {$this->options['db_table']} where generator_id=" . $this->db->quote($this->id) . " and id=" . $this->db->quote($key));
      $e = $res->fetch();
      $res->closeCursor();
      if ($e) {
        return true;
      }
    }

    if ($this->checkFun) {
      if (call_user_func($this->checkFun, $key)) {
        return true;
      }
    }

    if ($global) {
      global $allRandomIdGenerators;
      foreach ($allRandomIdGenerators as $gen) {
        if ($gen === $this) {
          continue;
        }

        if ($gen->check($key, false)) {
          return true;
        }
      }
    }

    return false;
  }

  function use($key) {
    $this->usedKeys[] = $key;
  }

  function addUsedKeys($list) {
    $this->usedKeys = array_merge($this->usedKeys, $list);
  }

  function setCheckFun($fun) {
    $this->checkFun = $fun;
  }

  function exportToJs($count) {
    $list = array();
    for ($i = 0; $i < $count; $i++) {
      $list[] = $this->get();
    }

    html_export_var(array("random_key_generator_{$this->id}" => $list));
  }
}
