<?php

namespace Tests\Unit\Post\CommandBuilder;

use App\Business\Commands\SavePostCommand;

class SavePostCommandBuilder
{

    private string $title;
    private string $content;
    private string $author;
    private ?string $postId;
    private ?string $createdAt;

    public static function asBuilder(): self
    {
        $self = new self();
        $self->title = '';
        $self->content = '';
        $self->author = '';
        $self->postId = null;
        $self->createdAt = null;

        return $self;
    }

    public function withTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function withContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function withAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function withPostId(string $postId): self
    {
        $this->postId = $postId;
        return $this;
    }

    public function build(): SavePostCommand
    {
        $command = new SavePostCommand(
            title: $this->title,
            content: $this->content,
            author: $this->author);
        $command->postId = $this->postId;
        $command->createdAt = $this->createdAt;
        return $command;
    }

    public function withCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}