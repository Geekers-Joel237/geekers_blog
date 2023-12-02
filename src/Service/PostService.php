<?php

namespace App\Service;

use App\Business\Commands\SavePostCommand;
use App\Business\Entities\Post;
use App\Business\Exceptions\ErrorOnSavePostException;
use App\Business\Repositories\PostRepository;
use App\Business\Responses\SavePostResponse;
use App\Business\UseCases\SavePostHandler;
use App\Business\Utils\Exceptions\NotEmptyException;
use App\Business\VO\Content;
use App\Business\VO\DateVo;
use App\Business\VO\FullName;
use App\Business\VO\Id;
use App\Business\VO\Title;

readonly class PostService implements SavePostHandler
{
    public function __construct(
        private PostRepository $repository
    )
    {
    }

    /**
     * @throws NotEmptyException
     * @throws ErrorOnSavePostException
     */
    public function handleSavePost(SavePostCommand $command): SavePostResponse
    {
        $response = new SavePostResponse();

        $post = Post::create(
            title: new Title($command->title),
            content: new Content($command->content),
            author: new FullName($command->author),
            postId: $command->postId ? new Id($command->postId) : null,
            createdAt: $command->createdAt ? new DateVo($command->createdAt) : null
        );

        $this->repository->save(post: $post);

        $response->isSaved = true;
        $response->postId = $post->id()->value();
        return $response;
    }
}