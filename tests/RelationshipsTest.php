<?php

namespace JsonApiParser\Tests;

use JsonApiParser\Collections\Document;
use JsonApiParser\Collections\DocumentItem;
use JsonApiParser\Parser;
use PHPUnit\Framework\TestCase;

class RelationshipsTest extends TestCase
{
    private $document;
    private $parser;

    public function __construct()
    {
        parent::__construct();
        $this->parser = new Parser(\file_get_contents(__DIR__ . '/json/json-api.json'));
        $this->document = $this->parser->data();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testInstanceOfAndRelationship()
    {
        $item = $this->document->get(0);
        $comments = $item->relationships('comments');
        $this->assertInstanceOf(Parser::class, $comments);

        $commentsItem = $this->parser->included()->get($comments->data()->get(0)->type(), $comments->data()->get(0)->id());

        $this->assertSame("comments", $comments->data()->get(0)->type());
        $this->assertSame(5, $comments->data()->get(0)->id());

        $this->assertInstanceOf(DocumentItem::class, $commentsItem);
        $author = $commentsItem->relationships("author");
        $this->assertInstanceOf(Parser::class, $author);

        $this->assertSame("people", $author->data()->get(0)->type());
        $this->assertSame(2, $author->data()->get(0)->id());

        $people = $this->parser->included()->get($author->data()->get(0)->type(), $author->data()->get(0)->id());
        $this->assertInstanceOf(DocumentItem::class, $people);

        $this->assertSame("dgeb2", $people->attribute()->twitter);
        $this->assertSame(1, $this->parser->includedInitCount);

        $this->assertSame("http://example.com/people/2", $people->links()->self);
    }

}
