<?php

namespace JsonApiParser\Tests;

use JsonApiParser\Collections\Document;
use JsonApiParser\Collections\DocumentItem;
use JsonApiParser\Collections\Included;
use JsonApiParser\Collections\Links;
use JsonApiParser\Collections\Relations;
use JsonApiParser\Parser;
use PHPUnit\Framework\TestCase;

class IteratorTest extends TestCase
{
    /**
     * links container
     *
     * @var Links
     */
    private $parser;

    public function __construct()
    {
        parent::__construct();
        $this->parser = new Parser(\file_get_contents(__DIR__ . '/json/json-api.json'));
    }

    public function testIterator()
    {
        $parser = $this->parser;
        $included = $parser->included();

        $this->assertInstanceOf(Parser::class, $parser);
        $this->assertInstanceOf(Relations::class, $included);
        $this->assertSame("1.0", $parser->version());

        $this->assertSame(6, $parser->meta()->total);
        $this->assertSame(2, $parser->meta()->current);

        $this->assertSame("http://example.com/articles", $parser->links()->self);
        $this->assertSame("http://example.com/articles?page[offset]=10", $parser->links()->last);

        $data = $parser->data();
        $this->assertInstanceOf(Document::class, $data);

        $i = 1;
        $title = [1 => "JSON:API paints my bikeshed!", 2 => "JSON:API paints my bikeshed 2!"];
        $commentsId = [1 => [1 => 5, 2 => 12], 2 => [1 => 13]];
        $twitters = [1 => [1 => "dgeb2", 2 => "dgeb"], 2 => [1 => "dgeb"]];
        $commentsBody = [1 => [1 => "First!", 2 => "I like XML better"], 2 => [1 => "I like XML better"]];
        foreach ($data as $item) {
            $this->assertInstanceOf(DocumentItem::class, $item);
            $this->assertSame("articles", $item->type());
            $this->assertSame($i, $item->id());
            $this->assertTrue($item->contain('attributes', 'title'));
            $this->assertSame($title[$i], $item->attribute()->title);

            $comments = $item->relationships("comments");
            $this->assertInstanceOf(Parser::class, $comments);

            $j = 1;
            foreach ($comments->data() as $comment) {
                $this->assertSame("comments", $comment->type());
                $this->assertSame($commentsId[$i][$j], $comment->id());
                $commentItem = $comment->comments();
                $this->assertSame($commentsBody[$i][$j], $commentItem->attribute()->body);
                $authors = $commentItem->relationships("author");
                foreach ($authors->data() as $author) {
                    $this->assertSame("people", $author->type()); 
                    $this->assertSame($twitters[$i][$j], $author->people()->attribute()->twitter);
                }

                $j++;
            }

            $i++;
        }

    }

}
