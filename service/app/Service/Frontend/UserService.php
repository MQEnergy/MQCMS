<?php
declare(strict_types = 1);

namespace App\Service\Frontend;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use Hyperf\HttpServer\Contract\RequestInterface;

class UserService extends \App\Service\Common\UserService
{
    /**
     * 推荐用户列表
     * @param RequestInterface $request
     * @return \Hyperf\Contract\PaginatorInterface
     */
    public function index(int $page = 1, int $limit = 10, $search = [])
    {
        try {
            $this->select = ['id', 'created_at', 'updated_at', 'user_name', 'nick_name', 'real_name', 'phone', 'avatar'];
            $this->with = ['userInfo' => ['user_id', 'intro', 'like_num', 'follow_num', 'fans_num', 'post_num', 'my_like_num']];
            $this->condition = ['status' => 1];
            return parent::index($page, $limit, $search);

        } catch (\Exception $e) {
            throw new BusinessException((int)$e->getCode(), $e->getMessage());
        }
    }

    /**
     * 用户信息（查看别人）
     * @param RequestInterface $request
     * @return mixed
     */
    public function profile($uid, $id)
    {
        try {
            $userFollowService = new UserFollowService();
            $this->with = ['userInfo' => ['user_id', 'intro', 'like_num', 'follow_num', 'fans_num', 'post_num', 'my_like_num']];
            $this->condition = [
                ['status', '=', 1],
                ['id', '=', $id]
            ];
            $this->select = ['id', 'user_name', 'nick_name', 'real_name', 'phone', 'avatar'];
            $data = parent::show();

            $data['is_follow'] = 0;
            if ($uid) {
                // 查询是否关注
                $userFollowService->condition = [
                    ['user_id', '=', $uid],
                    ['be_user_id', '=', $id]
                ];
                $exist = $userFollowService->multiTableJoinQueryBuilder()->exists();
                if ($exist) {
                    $data['is_follow'] = 1;
                }
            }
            return $data ?? [];

        } catch (\Exception $e) {
            throw new BusinessException((int)$e->getCode(), $e->getMessage());
        }
    }

    /**
     * 用户信息（查看自己）
     * @param RequestInterface $request
     * @return mixed
     */
    public function showSelf($uid)
    {
        try {
            $this->with = ['userInfo' => ['user_id', 'intro', 'like_num', 'follow_num', 'fans_num', 'post_num', 'my_like_num']];
            $this->condition = [
                ['status', '=', 1],
                ['id', '=', $uid]
            ];
            $this->select = ['id', 'user_name', 'nick_name', 'real_name', 'phone', 'avatar'];
            $data = parent::show();
            return $data ?? [];

        } catch (\Exception $e) {
            throw new BusinessException((int)$e->getCode(), $e->getMessage());
        }
    }


    /**
     * 用户帖子列表
     * @param RequestInterface $request
     * @return mixed
     */
    public function postList($post, $page, $limit)
    {
        try {
            $postService = new PostService();
            $userLikeService = new UserLikeService();
            $userFavoriteService = new UserFavoriteService();

            $postService->condition = [
                ['status', '=', 1],
                ['is_publish', '=', 1],
            ];
            $postIds = [];
            switch ($post['type']) {
                //用户发布的帖子列表
                case 1:
                    $postService->condition[] = ['user_id', '=', $post['id']];
                    break;

                //用户点赞的帖子列表
                case 2:
                    $userLikeService->condition = ['user_id' => $post['id']];
                    $postIds = $userLikeService->multiTableJoinQueryBuilder()->pluck('post_id')->toArray();
                    break;

                //用户收藏的帖子列表
                case 3:
                    $userFavoriteService->condition = ['user_id' => $post['id']];
                    $postIds = $userFavoriteService->multiTableJoinQueryBuilder()->pluck('post_id')->toArray();
                    break;

                //用户发布且含有商品的帖子列表
                case 4:
                    $postService->condition[] = ['user_id', '=', $post['id']];
                    $postService->condition[] = ['is_good', '=', 1];
                    break;

                default:
                    throw new BusinessException(ErrorCode::BAD_REQUEST, '参数错误');
                    break;
            }
            $query = $postService->multiTableJoinQueryBuilder();

            if (in_array($post['type'], [2, 3])) {
                $query = $query->whereIn('id', $postIds);
            }
            $count = $query->count();
            $pagination = $query->paginate((int)$limit, $this->select, 'page', (int)$page)->toArray();

            foreach ($pagination['data'] as $key => &$value) {
                $value['attach_urls'] = $value['attach_urls'] ? json_decode($value['attach_urls'], true) : [];
                $value['relation_tags_list'] = explode(',', $value['relation_tags']);
            }
            $pagination['total'] = $count;
            return $pagination;

        } catch (\Exception $e) {
            throw new BusinessException((int)$e->getCode(), $e->getMessage());
        }
    }

    /**
     * 我的关注用户列表
     * @param RequestInterface $request
     * @return mixed
     */
    public function myFollowedUserList($uid, $page, $limit)
    {
        try {
            $userFollowService = new UserFollowService();

            $userFollowService->condition = ['user_id' => $uid];
            $ids = $userFollowService->multiTableJoinQueryBuilder()->pluck('be_user_id')->toArray();
            $select = ['id', 'user_name', 'nick_name', 'avatar'];
            $this->select = $select;
            $this->condition = [
                ['status', '=', 1],
            ];
            if (!empty($ids)) {
                $query = $this->multiTableJoinQueryBuilder()->whereIn('id', $ids);
            }
            $count = $query->count();
            $pagination = $query->paginate((int)$limit, $select, 'page', (int)$page)->toArray();
            $pagination['total'] = $count;
            return $pagination;

        } catch (\Exception $e) {
            throw new BusinessException((int)$e->getCode(), $e->getMessage());
        }
    }

    /**
     * 我的关注标签列表
     * @param RequestInterface $request
     * @return mixed
     */
    public function myFollowedTagList($uid, $page, $limit)
    {
        try {
            $userTagService = new UserTagService();
            $userTagService->condition = ['user_id' => $uid];
            $ids = $userTagService->multiTableJoinQueryBuilder()->pluck('tag_id')->toArray();
            $select = ['id', 'tag_name'];
            $this->select = $select;
            $this->condition = [
                ['status', '=', 1],
            ];
            $tagService = new TagService();
            $query = $tagService->multiTableJoinQueryBuilder()->whereIn('id', $ids);
            $count = $query->count();
            $pagination = $query->paginate((int)$limit, $select, 'page', (int)$page)->toArray();
            $pagination['total'] = $count;
            return $pagination;

        } catch (\Exception $e) {
            throw new BusinessException((int)$e->getCode(), $e->getMessage());
        }
    }

}