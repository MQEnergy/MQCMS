<?php

declare (strict_types=1);
namespace App\Model\Common;

/**
 * @property int $id 
 * @property int $member_id 发布者id
 * @property int $cate_id 分类ID
 * @property string $post_title 标题
 * @property string $post_content 内容
 * @property string $post_excerpt 摘要
 * @property string $post_source 文章来源
 * @property string $thumb_url 缩略图
 * @property int $publish_time 发布时间
 * @property string $link_url 标题外链url
 * @property int $use_link 是否使用外链 1：使用 0：不使用
 * @property string $relation_tag_ids 关联标签ids 1,2...
 * @property string $relation_tags_name 关联标签 标签1,标签2...
 * @property string $relation_photo_urls 关联相册列表
 * @property string $relation_photo_ids 关联相册附件ids列表1,2,3...
 * @property string $relation_attach_urls 关联附件列表
 * @property int $status 状态 1：正常 0：删除
 * @property int $is_publish 是否发布 1：发布 0：未发布（草稿）
 * @property int $is_recommend 是否推荐 1：推荐 0：正常
 * @property int $is_top 是否置顶 1：置顶 0：正常
 * @property int $template_id 模板ID
 * @property int $sort_order 排序
 * @property int $like_total 点赞总数
 * @property int $favorite_total 收藏总数
 * @property int $comment_total 评论总数
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Post extends Model
{
    /**
     * @var string
     */
    protected $dateFormat = 'U';
    /**
     * @var bool
     */
    public $timestamps = true;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'member_id', 'cate_id', 'post_title', 'post_content', 'post_excerpt', 'post_source', 'thumb_url', 'publish_time', 'link_url', 'use_link', 'relation_tag_ids', 'relation_tags_name', 'relation_photo_urls', 'relation_photo_ids', 'relation_attach_urls', 'status', 'is_publish', 'is_recommend', 'is_top', 'template_id', 'sort_order', 'like_total', 'favorite_total', 'comment_total', 'created_at', 'updated_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'member_id' => 'integer', 'cate_id' => 'integer', 'publish_time' => 'integer', 'use_link' => 'integer', 'status' => 'integer', 'is_publish' => 'integer', 'is_recommend' => 'integer', 'is_top' => 'integer', 'template_id' => 'integer', 'sort_order' => 'integer', 'like_total' => 'integer', 'favorite_total' => 'integer', 'comment_total' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}