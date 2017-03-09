# DotArray

Handle data-arrays and key/value pairs in a fluent way by enabling dot-notation.

## Installation

Available through PHP composer

```
composer require rasmuscnielsen/dotarray
```


## Examples

Instantiate DotArray on a source
```
$source = array();
$dotArray = DotArray::tap($source);
```

Now start interacting with your source through DotArray
```
$cars = $dotArray->open('garage.cars');

$cars->put('mercedes', [
  'model' => 'S-class', 
  'origin' => 'Germany',
  'wheelsize' => '22 inches'
]);
$cars->add('mercedes', [
    'color' => 'blue'
]);

// you could even...
$dotArray->put('garage.cars.mercedes.color', 'blueish');

// or to delete
$garage->open('mercedes')->delete('origin');
```

Finally you can read out the values in a variety of ways
```
echo $dotArray->get('garage.cars.mercedes.model'); // S-class
echo $dotArray->get('garage.cars.merecedes.origin'); // NULL
echo $dotArray->get('garage.cars.mercedes.maxspeed', '250km/t'); // 250km/t

// or search out your object
$mercedes = $dotArray->open('garage.cars.mercedes');
echo $dotArray->wheelsize; // 22-inches

// of course you have the whole thing in your souce 
print_r($source); 

// [
//	'garage' => [
//    	'cars' => [
//        	'merecedes' => [
//				'model' => 'S-class',
//				etc...
//]
```
