<?php include "modulekit/loader.php"; /* loads all php-includes */ ?>
<html>
  <head>
    <title>Framework Example</title>
    <?php print modulekit_to_javascript(); /* pass modulekit configuration to JavaScript */ ?>
    <?php print modulekit_include_js(); /* prints all js-includes */ ?>
    <?php print modulekit_include_css(); /* prints all css-includes */ ?>
  </head>
  <body>
<pre>
<?php
$generator = new RandomIdGenerator(array(
//  'chars' => 'ABC123',
//  'length' => 6,
//  'prefix' => 'STO-',
//  'db' => new PDO('sqlite:data/foo.db'), // must be writeable!
//  'db_table' => 'different_table_name',
//  'db_timespan' => 5,
));
$generator->addUsedKeys(array('AAAA', 'BBBB'));
print ($x = $generator->get()) . "\n";
print $generator->get() . "\n";
print $generator->get() . "\n";
print $generator->get() . "\n";
print $generator->get() . "\n";
print "Reserved keys: "; print_r($generator->reservedKeys);
print "Used keys: "; print_r($generator->usedKeys);
$generator->use($x);
print "Reserved keys: "; print_r($generator->reservedKeys);
print "Used keys: "; print_r($generator->usedKeys);
?>
</pre>
  </body>
</html>
