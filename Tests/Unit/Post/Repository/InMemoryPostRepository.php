<?php

namespace Tests\Unit\Post\Repository;

use App\Business\Entities\Post;
use App\Business\Repositories\PostRepository;
use App\Business\VO\Id;

class InMemoryPostRepository implements PostRepository
{
    /**
     * @var Post[]
     */
    private array $posts = [];

    /**
     * @param Post $post
     * @return void
     */
    public function save(Post $post): void
    {
        $this->posts[$post->id()->value()] = $post;
    }

    public function byId(Id $postId): ?Post
    {
        if (array_key_exists($postId->value(), $this->posts)){
            return $this->posts[$postId->value()];
        }
        return null;
    }

    public function update(Post $post): void
    {
        $this->posts[$post->id()->value()] = $post;
    }
}