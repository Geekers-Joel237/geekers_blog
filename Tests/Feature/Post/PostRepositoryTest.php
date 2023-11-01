<?php

namespace Tests\Feature\Post;

use App\Business\Entities\Post;
use App\Business\Exceptions\ErrorOnQueryPostException;
use App\Business\Exceptions\ErrorOnSavePostException;
use App\Business\Repositories\PostRepository;
use App\Business\Utils\Exceptions\NotEmptyException;
use App\Business\VO\Content;
use App\Business\VO\FullName;
use App\Business\VO\Id;
use App\Business\VO\Title;
use App\Database\PdoConnection;
use App\Persistence\Repositories\Post\PdoPostRepository;
use PHPUnit\Framework\TestCase;

class PostRepositoryTest extends TestCase
{
    private PostRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new PdoPostRepository(new PdoConnection());
    }

    /**
     * @return void
     * @throws ErrorOnSavePostException
     * @throws NotEmptyException
     * @throws ErrorOnQueryPostException
     */
    public function test_can_create_a_post()
    {
        $initData = PostSUT::asSut()->withPost()->build();
        $postToSave = $initData->post;

        $this->repository->save(post: $postToSave);

        $dbSavedPost = $this->repository->byId($postToSave->id());

        $this->assertNotNull($dbSavedPost);
        $this->assertEquals($postToSave->title()->value(), $dbSavedPost->title()->value());
        $this->assertNotNull($dbSavedPost->createdAt());
        $this->assertNull($dbSavedPost->updatedAt());
    }


    /**
     * @return void
     * @throws ErrorOnQueryPostException
     * @throws ErrorOnSavePostException
     * @throws NotEmptyException
     */
    public function test_can_update_a_post()
    {
        $initData = PostSUT::asSut()->withExistingPost()->build();
        dd($initData);
        $dbPost = $initData->dbPost;
        $postToUpdate = Post::create(
            title: new Title('new Title'),
            content: new Content('new Content'),
            author: new FullName($dbPost->full_name),
            postId: new Id($dbPost->uuid)
        );

        $this->repository->update(post: $postToUpdate);

        $dbSavedPost = $this->repository->byId($postToUpdate->id());

        $this->assertNotNull($dbSavedPost);
        $this->assertEquals($postToUpdate->id()->value(), $dbSavedPost->id()->value());
        $this->assertEquals($postToUpdate->title()->value(), $dbSavedPost->title()->value());
        $this->assertNotNull($dbSavedPost->createdAt());
        $this->assertNotNull($dbSavedPost->updatedAt());
    }
}