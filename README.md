# Datastore

Handle data-arrays and key/value pairs in a fluent way. Ideal for abstracting session access.

## Installation

Available through PHP composer

```
composer require rasmuscnielsen/datastore
```


## Examples

```
$datastore = Datastore::root('showroom');

$mercedes = $datastore->open('cars.mercedes');

$mercedes->write([
  'model' => 'S-class', 
  'origin' => 'germany'
]);

$mercedes->append(['passengers' => 4]);

$mercedes->write('colour', 'blue');

$mercedes->delete('origin');

var_dump($datastore->read('cars.mercedes')); // Now containts model, passengers, colour
```
