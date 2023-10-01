<?php

namespace App\Business\Commands;

class SavePostCommand
{

    public ?string $postId;
    /**
     * @param string $title
     * @param string $content
     * @param string $author
     */
    public function __construct(
        public string $title,
        public string $content,
        public string $author
    )
    {
        $this->postId = null;
    }

}