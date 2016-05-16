# DotArray

Handle data-arrays and key/value pairs in a fluent way by enabling dot-notation.

## Installation

Available through PHP composer

```
composer require rasmuscnielsen/dotarray
```


## Examples

```
$yourArray = array();

$dotArray = DotArray::init($yourArray);

$mercedes = $dotArray->open('cars.mercedes');

$mercedes->write([
  'model' => 'S-class', 
  'origin' => 'germany'
]);

$mercedes->append(['passengers' => 4]);

$mercedes->write('colour', 'blue');

$mercedes->delete('origin');

var_dump($dotArray->read('cars.mercedes')); // Now contains model, passengers, colour
```
