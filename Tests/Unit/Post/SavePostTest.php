<?php

namespace Tests\Unit\Post;

use App\Business\Commands\SavePostCommand;
use App\Business\Responses\SavePostResponse;
use App\Business\UseCases\SavePostHandler;
use App\Business\Utils\Exceptions\NotEmptyException;
use App\Service\PostService;
use PHPUnit\Framework\TestCase;

class SavePostTest extends TestCase
{
    private SavePostHandler $handler;
    public function setUp(): void
    {
        parent::setUp();
        $this->handler = new PostService();
    }

    public function test_can_create_a_post()
    {
        $command = new SavePostCommand(
            title: "My first Post",
            content: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                            when an unknown printer took a galley of type and scrambled it to make a type 
                            specimen book. It has survived not only five centuries, but also the leap into 
                            electronic typesetting, remaining essentially unchanged. It was popularised in 
                            the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
                            and more recently with desktop publishing software like Aldus PageMaker including 
                            versions of Lorem Ipsum.",
            author: "Geekers Joel"
        );
        $response = $this->savePost($command);

        $this->assertTrue($response->isSaved);
        $this->assertNotNull($response->postId);
    }

    public function test_can_throw_not_empty_exception()
    {
        $command = new SavePostCommand(
            title: "",
            content: "",
            author: ""
        );
        $this->expectException(NotEmptyException::class);
        $this->savePost($command);

    }

    private function savePost(SavePostCommand $command): SavePostResponse
    {
        return $this->handler->handleSavePost($command);
    }
}