<?php

namespace App\Business\Repositories;

use App\Business\Entities\Post;
use App\Business\Exceptions\ErrorOnSavePostException;
use App\Business\VO\Id;

interface PostRepository
{
    /**
     * @param Post $post
     * @return void
     * @throws ErrorOnSavePostException
     */
    public function save(Post $post): void;

    /**
     * @param Id $postId
     * @return Post|null
     */
    public function byId(Id $postId): ?Post;

    public function update(Post $post): Id;
}