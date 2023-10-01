<?php

namespace Tests\Feature\Post;

use App\Business\Entities\Post;
use App\Business\Utils\Exceptions\NotEmptyException;
use App\Business\VO\Content;
use App\Business\VO\FullName;
use App\Business\VO\Title;

class PostSUT
{

    public ?Post $post;

    /**
     * @return self
     */
    public static function asSut(): self
    {
        $self = new self();
        $self->post = null;
        return $self;
    }

    /**
     * @throws NotEmptyException
     */
    public function withPost(): self
    {
        $time = microtime(true);
        $this->post = Post::create(
            title: new Title("An existing Post".$time),
            content:new Content("Old Post Content"),
            author: new FullName("Geekers_Joel237")
        );
        return $this;
    }

    /**
     * @return $this
     */
    public function build(): self
    {
        return $this;
    }
}