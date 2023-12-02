<?php

namespace App\Business\Commands;

class SavePostCommand
{

    public ?string $postId;
    public ?string $createdAt;

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
        $this->postId = $this->createdAt = null;
    }

}