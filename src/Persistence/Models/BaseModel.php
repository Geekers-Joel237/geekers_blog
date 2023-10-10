<?php

namespace App\Persistence\Models;

use App\Database\Factories\BaseFactory;

class BaseModel
{
    use BaseFactory;
    private array|self $static;
    private array $serialize;

    public static function factory(?int $int = 1): self
    {
        $self = new static();
        for ($i = 0; $i < $int; $i++) {
            $self->serialize[] = $self->definition();
        }
        return $self;
    }



    public function create(?array $array = null): static|array
    {
        if (count($this->serialize) === 1) {
            return $this->createModel($this->serialize[0]);
        }
        return new static();
    }

    private function createModel(array $serialize): static
    {
        return static::new($serialize);
    }


}