A random ID generator.

# API
## Constructor
The constructor accepts an options parameter. The following options are available:

- chars: list of characters from which IDs will be generated, e.g. 'ABC123'. Default: all upper characters and all digits.
- length: length of a random ID, default: 4.
- prefix: prefix IDs by some string, default: ''.

## get()
Return a new random id.

## check(key)
Return true, if the key is already used.

## use(key)
Add the key to the list of used keys.

## addUsedKeys()
Add an array of used keys to the Generator, so they won't be returned again.

## usedKeys
Property, with a list of used keys.
