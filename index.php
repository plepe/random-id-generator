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
));
print $generator->get() . "\n";
print $generator->get() . "\n";
print $generator->get() . "\n";
print $generator->get() . "\n";
print $generator->get() . "\n";
?>
</pre>
  </body>
</html>
