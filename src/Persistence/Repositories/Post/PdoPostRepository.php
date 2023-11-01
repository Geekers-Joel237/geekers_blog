<?php

namespace App\Persistence\Repositories\Post;

use App\Business\Entities\Post;
use App\Business\Enum\ActionEnum;
use App\Business\Exceptions\ErrorOnQueryPostException;
use App\Business\Exceptions\ErrorOnSavePostException;
use App\Business\Repositories\PostRepository;
use App\Business\Utils\Database\DBConnection;
use App\Business\Utils\Exceptions\NotEmptyException;
use App\Business\Utils\Stringify;
use App\Business\VO\Content;
use App\Business\VO\DateVo;
use App\Business\VO\FullName;
use App\Business\VO\Id;
use App\Business\VO\StringVo;
use App\Business\VO\Title;
use Exception;
use PDO;
use PDOException;

readonly class PdoPostRepository implements PostRepository
{
    public function __construct(
        private DBConnection $connection
    )
    {
    }

    /**
     * @param Post $post
     * @return void
     * @throws ErrorOnSavePostException
     */
    public function save(Post $post): void
    {
        $postDataToSave = Stringify::fromArray($post->toArray(), ActionEnum::SAVE);
        try {
            $sql = "
                    INSERT INTO posts 
                    $postDataToSave ";
            $st = $this->connection->getConnection()->prepare($sql);
            $st->execute();

        } catch (PDOException|Exception $e) {
            throw new ErrorOnSavePostException($e->getMessage());
        }
    }

    /**
     * @param Id $postId
     * @return Post|null
     * @throws NotEmptyException
     * @throws ErrorOnQueryPostException
     */
    public function byId(Id $postId): ?Post
    {
        $value = $postId->value();
        $sql = "
            SELECT 
                uuid AS postId,
                title,
                slug,
                content,
                full_name AS fullName,
                created_at AS createdAt,
                updated_at AS updatedAt,
                deleted_at AS deletedAt
            FROM
            posts
            WHERE uuid =:postId AND is_deleted = false;
        ";

        try {
            $st = $this->connection->getConnection()->prepare($sql);
            $st->bindParam('postId', $value);
            $st->setFetchMode(PDO::FETCH_OBJ);
            $st->execute();
            $result = $st->fetch();
        } catch (PDOException|Exception $e) {
            throw new ErrorOnQueryPostException($e->getMessage());
        }

        if (!$result) {
            return null;
        }

        return $this->transformToPost($result);
    }

    /**
     * @param mixed $result
     * @return Post
     * @throws NotEmptyException
     */
    private function transformToPost(mixed $result): Post
    {
        return new Post(
            postId: new Id($result->postId),
            title: new Title($result->title),
            slug: new StringVo($result->slug),
            content: new Content($result->content),
            fullName: new FullName($result->fullName),
            createdAt: new DateVo($result->createdAt)
        );
    }

    /**
     * @throws ErrorOnSavePostException
     */
    public function update(Post $post): void
    {
        $id = $post->id()->value();
        $postDataToUpdate = Stringify::fromArray($post->toArray(), ActionEnum::UPDATE);
        try {
            $sql = "
                    UPDATE posts SET
                    $postDataToUpdate 
                    WHERE uuid = :id";
            $st = $this->connection->getConnection()->prepare($sql);
            $st->bindParam('id', $id);
            $isUpdated = $st->execute();

            if (!$isUpdated) {
                throw new ErrorOnSavePostException("Erreur lors de la modification du post");
            }
        } catch (PDOException|Exception $e) {
            throw new ErrorOnSavePostException($e->getMessage());
        }

    }
}