A random ID generator.

# PHP API
## Constructor
The constructor accepts an options parameter. The following options are available:

- id: id of the generator.
- chars: list of characters from which IDs will be generated, e.g. 'ABC123'. Default: all upper characters and all digits.
- length: length of a random ID, default: 4.
- prefix: prefix IDs by some string, default: ''.
- db: an active PDO database connection where keys will be blocked for `db_timespan` seconds. if unset, no database will be used.
- db_table: table name for the reserved keys, default: '__random_id_generator__'.
- db_timespan: timespan, how long keys will be blocked, default: 3600.


## get()
Return a new random id and add it the the list of used keys.

## check(key)
Return true, if the key is already used.

## use(key)
Add the key to the list of used keys.

## addUsedKeys()
Add an array of used keys to the Generator, so they won't be returned again.

## exportToJs(count)
Export count keys to JS, so they can be returned inside a web browser.

## usedKeys
Property, with a list of used keys.

# JS API
The JS API does not have a generator itself, but you need to export keys to the JS environment, which can than be used.

```js
var generator = new RandomIdGenerator()
alert(generator.get())
```

If you plan to use several generators, it's necessary to use different ids.

## get()
Return a new random id from the exported pool.
