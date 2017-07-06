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

    if ($this->db) {
      $this->initDb();
    }
  }

  function initDb() {
    $res = $this->db->query("select 1 from {$this->options['db_table']}");
    if ($res === false) {
      $query = <<<EOT
create table {$this->options['db_table']} (
  id		varchar(255) not null,
  key           varchar(255) not null,
  ts            text,
  primary key(id, key)
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

    if ($this->db) {
      $db_timeout = Date('Y-m-d H:i:s', time() + $this->options['db_timespan']);
      $res = $this->db->query("insert into {$this->options['db_table']} values (1, " . $this->db->quote($r) . ", " . $this->db->quote($db_timeout) . ")");
    }

    return $r;
  }

  function check($key) {
    if (in_array($key, $this->usedKeys))
      return true;

    if ($this->db) {
      $res = $this->db->query("select * from {$this->options['db_table']} where key=" . $this->db->quote($key));
      $e = $res->fetch();
      $res->closeCursor();
      if ($e) {
        return false;
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
}
