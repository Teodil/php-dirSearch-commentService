<?php

namespace Teodil\CommentService\Tests;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Teodil\CommentService\CommentService;
use Teodil\CommentService\Models\Comment;
use Teodil\CommentService\Models\CreateCommentDTO;

class CommentServiceTests extends TestCase
{
    private CommentService $commentService;
    private Client $mockHttpClient;
    private MockHandler $mockHandler;


    protected function setUp(): void
    {
        $this->mockHandler = new MockHandler();
        $this->mockHttpClient = new Client(['handler' => HandlerStack::create($this->mockHandler)]);
        $this->commentService = new CommentService('http://example.com');
        $this->commentService->setMockHttpClient($this->mockHttpClient);
    }

    public function testGetComments(): void
    {
        $responseBody = json_encode([
            ['id' => 1, 'name' => 'Alice', 'text' => 'First comment'],
            ['id' => 2, 'name' => 'Bob', 'text' => 'Second comment'],
        ]);
        $this->mockHandler->append(new Response(200, body: $responseBody));
        $comments = $this->commentService->getComments();

        $this->assertCount(2, $comments);
        $this->assertEquals('Alice', $comments[0]->name);
    }

    public function testAddComment(): void
    {
        $responseBody = json_encode(['id' => 1, 'name' => 'Alice', 'text' => 'Hello!']);
        $this->mockHandler->append(new Response(200, body: $responseBody));

        $createDto = new CreateCommentDTO('Alice', 'Hello!');
        $comment = $this->commentService->newComment($createDto);

        $this->assertEquals(1, $comment->id);
        $this->assertEquals('Alice', $comment->name);
    }

    public function testUpdateComment(): void
    {
        $responseBody = json_encode(['id' => 1, 'name' => 'Alice', 'text' => 'Updated text']);
        $this->mockHandler->append(new Response(200, body: $responseBody));

        $updateComment = new Comment(1, 'Alice', 'Updated text');
        $comment = $this->commentService->updateComment($updateComment);

        $this->assertEquals(1, $comment->id);
        $this->assertEquals('Updated text', $comment->text);
    }

    public function testApiException(): void
    {
        $this->mockHandler->append(new Response(500));
        $this->expectException(ServerException::class);
        $this->commentService->getComments();

        $this->mockHandler->append(new Response(400));
        $this->expectException(ClientException::class);
        $this->commentService->getComments();
    }


}
