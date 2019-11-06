# {JSON:API} Parser
![PHP from Packagist](https://img.shields.io/packagist/php-v/zohurul/json-api-parser) ![Packagist](https://img.shields.io/packagist/l/zohurul/json-api-parser)
A PHP package to parser ***{JSON:API}*** Response parser or you can say deserializer. 

:bulb: Before start please note that this library only work with [{JSON:API}](https://jsonapi.org/) resources, please visit [https://jsonapi.org](https://jsonapi.org/) for more details.
### Installation

    composer require zohurul/json-api-parser:dev-master

### Getting Started
You can simply use the ***Parser*** class to parser the the json string.
``` php 

use JsonApiParser/Parser;
$parser =new Parser($jsonString);

```
##### try to parse a json string
the ***ParserException*** to catch all exception
```php

use JsonApiParser\Parser;
use JsonApiParser\Exceptions\ParserException;

try{
	$parser = new Parser($jsonString);
}catch(ParserException $e){
	echo $e->getMessage();
}

```