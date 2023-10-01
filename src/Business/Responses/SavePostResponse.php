<?php

namespace App\Business\Responses;

class SavePostResponse
{
    public bool $isSaved = false;
    public ?string $postId = null;
}