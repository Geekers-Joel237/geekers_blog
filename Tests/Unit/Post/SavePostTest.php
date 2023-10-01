<?php

namespace Tests\Unit\Post;

use App\Business\Commands\SavePostCommand;
use App\Business\Entities\Post;
use App\Business\Repositories\PostRepository;
use App\Business\Responses\SavePostResponse;
use App\Business\UseCases\SavePostHandler;
use App\Business\Utils\Exceptions\NotEmptyException;
use App\Business\VO\Content;
use App\Business\VO\FullName;
use App\Business\VO\Id;
use App\Business\VO\Title;
use App\Service\PostService;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Post\Repositories\InMemoryPostRepository;

class SavePostTest extends TestCase
{
    private SavePostHandler $handler;
    private PostRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new InMemoryPostRepository();
        $this->handler = new PostService($this->repository);
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

    public function test_can_save_a_post_when_is_create()
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

        $this->assertNotNull($this->repository->byId(new Id($response->postId)));
    }

    /**
     * @throws NotEmptyException
     */
    public function test_can_save_post_when_is_update()
    {
        $initData  = $this->buildSUT();
        $existingPostId = $initData['existingPostId'];
        $command = new SavePostCommand(
            title: "My first Post modified",
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
        $command->postId = $existingPostId;

        $response = $this->savePost($command);

        $this->assertEquals($existingPostId, $response->postId);
    }

    /**
     * @throws NotEmptyException
     */
    private function savePost(SavePostCommand $command): SavePostResponse
    {
        return $this->handler->handleSavePost($command);
    }

    /**
     * @throws NotEmptyException
     */
    private function buildSUT(): array
    {
        $existingPost = Post::create(
            title: new Title("An existing Post"),
            content:new Content("Old Post Content"),
            author: new FullName("Geekers_Joel237"),
            postId: Id::nextIdentifier()
        );

        $this->repository->save($existingPost);

        return ["existingPostId" => $existingPost->id()->value()];
    }
}