drop table if exists posts;

create table posts
(
    uuid       VARCHAR(255)  not null comment 'table id',
    title      VARCHAR(512)           not null comment 'title of a post',
    slug       VARCHAR(512)           not null comment 'slug from post title',
    content    LONGTEXT               null comment 'post content',
    full_name  VARCHAR(255)           not null,
    created_at datetime               null comment 'creation date',
    is_deleted boolean      default 0 not null comment 'soft delete check',
    updated_at datetime               null comment 'updated date',
    deleted_at datetime               null comment 'delete date',
    constraint posts_pk
        primary key (uuid),
    constraint posts_pk2
        unique (slug)
);

