# {JSON:API} Parser
![PHP from Packagist](https://img.shields.io/packagist/php-v/zohurul/json-api-parser) ![Packagist](https://img.shields.io/packagist/l/zohurul/json-api-parser)

A PHP package to parser ***{JSON:API}*** Response parser or you can say deserializer. 

:bulb: Before start please note that this library only work with [{JSON:API}](https://jsonapi.org/) resources, please visit [https://jsonapi.org](https://jsonapi.org/) for more details.
### Installation

    composer require zohurul/json-api-parser

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

#### a very complex example
suppose we have receive this json response from our client
```json
{
    "jsonapi": {
        "version": "1.0"
    },
    "meta": {
        "total": 6,
        "current": 2
    },
    "links": {
        "self": "http://example.com/articles",
        "next": "http://example.com/articles?page[offset]=2",
        "last": "http://example.com/articles?page[offset]=10"
    },
    "data": [
        {
            "type": "articles",
            "id": "1",
            "attributes": {
                "title": "JSON:API paints my bikeshed!"
            },
            "relationships": {
                "author": {
                    "links": {
                        "self": "http://example.com/articles/1/relationships/author",
                        "related": "http://example.com/articles/1/author"
                    },
                    "data": {
                        "type": "people",
                        "id": "9"
                    }
                },
                "comments": {
                    "links": {
                        "self": "http://example.com/articles/1/relationships/comments",
                        "related": "http://example.com/articles/1/comments"
                    },
                    "data": [
                        {
                            "type": "comments",
                            "id": "5"
                        },
                        {
                            "type": "comments",
                            "id": "12"
                        }
                    ]
                }
            },
            "links": {
                "self": "http://example.com/articles/1"
            }
        },
        {
            "type": "articles",
            "id": "2",
            "attributes": {
                "title": "JSON:API paints my bikeshed 2!"
            },
            "relationships": {
                "author": {
                    "links": {
                        "self": "http://example.com/articles/1/relationships/author",
                        "related": "http://example.com/articles/1/author"
                    },
                    "data": {
                        "type": "people",
                        "id": "19"
                    }
                },
                "comments": {
                    "links": {
                        "self": "http://example.com/articles/1/relationships/comments",
                        "related": "http://example.com/articles/1/comments"
                    },
                    "data": {
                        "type": "comments",
                        "id": "13"
                    }
                }
            },
            "links": {
                "self": "http://example.com/articles/1"
            }
        }
    ],
    "included": [
        {
            "type": "people",
            "id": "9",
            "attributes": {
                "firstName": "Dan",
                "lastName": "Gebhardt",
                "twitter": "dgeb"
            },
            "links": {
                "self": "http://example.com/people/9"
            }
        },
        {
            "type": "people",
            "id": "2",
            "attributes": {
                "firstName": "Dan2",
                "lastName": "Gebhardt2",
                "twitter": "dgeb2"
            },
            "links": {
                "self": "http://example.com/people/2"
            }
        },
        {
            "type": "comments",
            "id": "5",
            "attributes": {
                "body": "First!"
            },
            "relationships": {
                "author": {
                    "data": {
                        "type": "people",
                        "id": "2"
                    }
                }
            },
            "links": {
                "self": "http://example.com/comments/5"
            }
        },
        {
            "type": "comments",
            "id": "12",
            "attributes": {
                "body": "I like XML better"
            },
            "relationships": {
                "author": {
                    "data": {
                        "type": "people",
                        "id": "9"
                    }
                }
            },
            "links": {
                "self": "http://example.com/comments/12"
            }
        },
        {
            "type": "comments",
            "id": "13",
            "attributes": {
                "body": "I like XML better"
            },
            "relationships": {
                "author": {
                    "data": {
                        "type": "people",
                        "id": "9"
                    }
                }
            },
            "links": {
                "self": "http://example.com/comments/12"
            }
        },
        {
            "type": "comments",
            "id": "17",
            "attributes": {
                "body": "I like XML better"
            },
            "relationships": {
                "author": {
                    "data": {
                        "type": "people",
                        "id": "9"
                    }
                }
            },
            "links": {
                "self": "http://example.com/comments/12"
            }
        }
    ]
}
```
And we wanted to print all the information by nested loop

```php
use JsonApiParser\Parser; 

$parser = new Parser($jsonString); 
//To print a version
echo $parser->version();
//Whole meta object
print_r($parser->meta());
//Single meta object
echo $parser->meta()->total;

//To get whole links object
print_r($parser->links());
//To get a single link
echo $parser->links()->self;

//prepare included relational data
$included = $parser->included();
//main data block
$articles = $parser->data(); 

foreach ($articles as $article) { 
    //print the article type
    echo $article->type();
    //print the article id
    echo $article->id();
    
    //To check if any specific key exist
    var_dump($item->contain('attributes', 'title'));
    
    //to print an item attribute
    echo $item->attribute()->title;
    
    //Fetch a relationship object by relationship name
    $comments = $item->relationships("comments"); 
    
    //To print all the comments
    foreach ($comments->data() as $comment) { 
        //print the id
        echo $comment->id();
        //Fetch the relational data from included
        $commentItem = $comment->comments();

        //print it's attribute
        echo $commentItem->attribute()->body;
        
        $authors = $commentItem->relationships("author");
        foreach($authors->data() as $author){
            //author id
            echo $author->id();

            //to print the author attribute item
            echo $author->people()->attribute()->twitter;
        }
                
     }

}