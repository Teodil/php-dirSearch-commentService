<?php

namespace Teodil\CommentService;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Teodil\CommentService\Models\Comment;
use Teodil\CommentService\Models\CreateCommentDTO;

class CommentService
{
    private Client $httpClient;

    public function __construct(string $baseUrl){
        $this->httpClient = new Client([
            'base_uri' => $baseUrl,
        ]);
    }

    public function setMockHttpClient(Client $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return Comment[]
     * @throws GuzzleException
     */
    public function getComments(): array
    {
        $response = $this->makeRequest("comments","GET");

        $comments = [];
        foreach ($response as $item) {
            $comments[] = new Comment($item['id'], $item['name'], $item['text']);
        }

        return $comments;
    }

    /**
     * @param CreateCommentDTO $comment
     * @return Comment
     * @throws GuzzleException
     */
    public function newComment(CreateCommentDTO $comment) : Comment
    {
        $response = $this->makeRequest("comment", "POST", (array)$comment);

        return new Comment($response['id'], $response['name'], $response['text']);
    }

    /**
     * @param Comment $comment
     * @return Comment
     * @throws GuzzleException
     */
    public function updateComment(Comment $comment) : Comment
    {
        $path = '/comment/' . $comment->id;
        $response = $this->makeRequest($path, "PUT", (array)$comment);
        return new Comment($response['id'], $response['name'], $response['text']);
    }

    /**
     * @throws GuzzleException
     */
    private function makeRequest(string $path, string $method, array $data=[]):array
    {
        $response = $this->httpClient->request($method,$path,[
            'body'=>json_encode($data)
        ]);

        return json_decode($response->getBody(), true);
    }

}