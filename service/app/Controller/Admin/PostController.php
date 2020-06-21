<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Logic\Admin\PostLogic;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use App\Middleware\AuthMiddleware;

/**
 * @Controller()
 * @Middleware(AuthMiddleware::class)
 * Class PostController
 * @package App\Controller\Admin
 */
class PostController extends BaseController
{
    /**
     * @Inject()
     * @var PostLogic
     */
    public $logic;

    /**
     * @PostMapping(path="store")
     * @param RequestInterface $request
     * @return int
     */
    public function store(RequestInterface $request)
    {
        $post = $this->validateParam($request, [
            'cate_id' => 'required',
            'post_title' => 'required',
            'post_content' => 'required',
        ]);
        $post['member_id'] = $request->getAttribute('uid');
        $post['post_excerpt']= $request->input('post_excerpt', '');
        $post['post_source'] = $request->input('post_source', '');
        $post['thumb_url'] = $request->input('thumb_url', '');
        $post['publish_time'] = strtotime($request->input('publish_time', date('Y-m-d H:i:s')));
        $post['link_url'] = $request->input('link_url', '');
        $post['use_link'] = $request->input('use_link', '');
        $post['relation_tag_ids'] = $request->input('relation_tag_ids', '');
        $post['relation_tags_name'] = $request->input('relation_tags_name', '');
        $post['status'] = $request->input('status', 1);
        $post['is_publish'] = $request->input('is_publish', 1);
        $post['is_recommend'] = $request->input('is_recommend', 1);
        $post['is_top'] = $request->input('is_top', 1);
        $post['template_id'] = $request->input('template_id', 0);
        $post['sort_order'] = $request->input('sort_order', 50);
        $post['like_total'] = $request->input('like_total', 0);
        $post['favorite_total'] = $request->input('favorite_total', 0);
        $post['comment_total'] = $request->input('comment_total', 0);
        return $this->logic->store($post);
    }

    /**
     * @PostMapping(path="update")
     * @param RequestInterface $request
     * @return int
     */
    public function update(RequestInterface $request)
    {
        $post = $this->validateParam($request, [
            'id' => 'required',
            'cate_id' => 'required',
            'post_title' => 'required',
            'post_content' => 'required',
        ]);
        $post['member_id'] = $request->getAttribute('uid');
        $post['post_excerpt']= $request->input('post_excerpt', '');
        $post['post_source'] = $request->input('post_source', '');
        $post['thumb_url'] = $request->input('thumb_url', '');
        $post['publish_time'] = strtotime($request->input('publish_time', date('Y-m-d H:i:s')));
        $post['link_url'] = $request->input('link_url', '');
        $post['use_link'] = $request->input('use_link', '');
        $post['relation_tag_ids'] = $request->input('relation_tag_ids', '');
        $post['relation_tags_name'] = $request->input('relation_tags_name', '');
        $post['status'] = $request->input('status', 1);
        $post['is_publish'] = $request->input('is_publish', 1);
        $post['is_recommend'] = $request->input('is_recommend', 1);
        $post['is_top'] = $request->input('is_top', 1);
        $post['template_id'] = $request->input('template_id', 0);
        $post['sort_order'] = $request->input('sort_order', 50);
        $post['like_total'] = $request->input('like_total', 0);
        $post['favorite_total'] = $request->input('favorite_total', 0);
        $post['comment_total'] = $request->input('comment_total', 0);
        return $this->logic->update($post);
    }
}