<?php

namespace App\Persistence\Models;

use App\Business\Utils\StrHelper;

class Post extends BaseModel
{
    public string $uuid;
    public string $title;
    public string $slug;
    public string $full_name;
    public ?string $content;
    public string $created_at;
    public ?string $updated_at;
    public ?string $deleted_at;

    public function __construct()
    {
        $this->content = null;
        $this->updated_at = null;
        $this->deleted_at = null;

    }

    public static function new(array $serialize): self
    {
        $self = new self();
        $self->uuid = $serialize['uuid'];
        $self->title = $serialize['title'];
        $self->slug = $serialize['slug'];
        $self->full_name = $serialize['full_name'];
        $self->content = $serialize['content'];
        $self->created_at = $serialize['created_at'];

        return $self;
    }

    public function definition(): array
    {
        return [
            'uuid' => $this->faker()->uuid,
            'title' => $title = $this->faker()->title,
            'slug' => StrHelper::slugify($title),
            'full_name' => $this->faker()->userName,
            'content' => $this->faker()->realTextBetween(1000, 10000),
            'created_at' => $this->faker()->date('Y-m-d', 'now')
        ];
    }
}