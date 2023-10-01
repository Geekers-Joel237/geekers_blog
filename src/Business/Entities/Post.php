<?php

namespace App\Business\Entities;

use App\Business\Utils\Exceptions\NotEmptyException;
use App\Business\Utils\StrHelper;
use App\Business\VO\Content;
use App\Business\VO\DateVo;
use App\Business\VO\FullName;
use App\Business\VO\Id;
use App\Business\VO\StringVo;
use App\Business\VO\Title;

class Post
{

    private ?DateVo $updatedAt;

    /**
     * @param Id $postId
     * @param Title $title
     * @param StringVo $slug
     * @param Content $content
     * @param FullName $fullName
     * @param DateVo $createdAt
     */
    public function __construct(
        private readonly Id     $postId,
        private Title           $title,
        private StringVo        $slug,
        private Content         $content,
        private FullName        $fullName,
        private readonly DateVo $createdAt,
    )
    {
        $this->updatedAt = null;
    }

    /**
     * @param Title $title
     * @param Content $content
     * @param FullName $author
     * @param Id|null $postId
     * @return self
     * @throws NotEmptyException
     */
    public static function create(
        Title    $title,
        Content  $content,
        FullName $author,
        ?Id      $postId
    ): self
    {
        return new self(
            postId: $postId ?? Id::nextIdentifier(),
            title: $title,
            slug: new StringVo(self::generateSlugFromTitle($title)),
            content: $content,
            fullName: $author,
            createdAt: new DateVo()
        );
    }

    /**
     * @param Title $title
     * @return string
     */
    private static function generateSlugFromTitle(Title $title): string
    {
        return StrHelper::slugify($title->value());
    }

    /**
     * @return Id
     */
    public function id(): Id
    {
        return $this->postId;
    }
}