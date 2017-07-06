<?php include "modulekit/loader.php"; /* loads all php-includes */ ?>
<?php
$generator = new RandomIdGenerator(array(
  'id' => 'foo',
//  'chars' => 'ABC123',
//  'length' => 6,
//  'prefix' => 'STO-',
//  'db' => new PDO('sqlite:data/foo.db'), // must be writeable!
//  'db_table' => 'different_table_name',
//  'db_timespan' => 5,
));
$generator->exportToJs(16);
?>
<html>
  <head>
    <title>Framework Example</title>
    <?php print modulekit_to_javascript(); /* pass modulekit configuration to JavaScript */ ?>
    <?php print modulekit_include_js(); /* prints all js-includes */ ?>
    <?php print modulekit_include_css(); /* prints all css-includes */ ?>
    <?php print_add_html_headers(); ?>
  </head>
  <body>
<pre>
<?php
$generator->addUsedKeys(array('AAAA', 'BBBB'));
print ($x = $generator->get()) . "\n";
print $generator->get() . "\n";
print $generator->get() . "\n";
print $generator->get() . "\n";
print $generator->get() . "\n";
print "Used keys: "; print_r($generator->usedKeys);
print "$x: " . ($generator->check($x) ? "used" : "not used") . "\n";
$generator->use($x);
print "Used keys: "; print_r($generator->usedKeys);
?>
</pre>
<script>
var generator = new RandomIdGenerator({
  id: 'foo'
})
alert(generator.get())
alert(generator.get())
</script>
  </body>
</html>
