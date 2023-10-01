<?php

namespace App\Business\UseCases;

use App\Business\Commands\SavePostCommand;
use App\Business\Responses\SavePostResponse;

interface SavePostHandler
{
    public function handleSavePost(SavePostCommand $command): SavePostResponse;

}