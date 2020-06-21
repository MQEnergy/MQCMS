<?php
declare(strict_types = 1);

namespace App\Service\Frontend;

use App\Exception\BusinessException;
use App\Utils\Common;
use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Contract\RequestInterface;

class PostService extends \App\Service\Common\PostService
{
    /**
     * 帖子列表分页
     * @param RequestInterface $request
     * @return mixed
     */
    public function getList(int $page, int $limit, $search=[], $post=[])
    {
        $this->condition = [
            ['status', '=', 1],
            ['is_publish', '=', 1],
        ];
        if (isset($post['type']) && $post['type'] === 'recommend') {
            $this->condition[] = ['is_recommend', '=', 1];
        }
        $list = parent::index($page, $limit, $search);
        $list['data'] = Common::calculateList($page, $limit, $list['data']);
        return $list;
    }

    /**
     * 发帖
     * @param $post
     * @param $data
     * @return int
     */
    public function publish($post, $data)
    {
        $this->data = $data;
        Db::beginTransaction();
        try {
            $lastInsertId = parent::store();

            // 存储tag
            $tagPostRelationService = new TagPostRelationService();
            $userInfoService = new UserInfoService();

            if (!empty($post['relationTagIds'])) {
                foreach ($post['relationTagIds'] as $value) {
                    // todo
                    $tagPostRelationService->data = [
                        'user_id' => $post['uid'],
                        'tag_id' => $value,
                        'post_id' => $lastInsertId,
                        'created_at' => time(),
                        'updated_at' => time()
                    ];
                }
                $tagPostRelationService->insert();
            }
            //更新我的发帖数
            $userInfoService->condition = ['user_id' => $post['uid']];
            $userInfoService->multiTableJoinQueryBuilder()->increment('post_num');

            Db::commit();
            return $lastInsertId;

        } catch (\Exception $e) {
            Db::rollBack();
            $message = $post['isPublish'] ? '发布失败' : '保存失败';
            throw new BusinessException((int)$e->getCode(), $message);
        }
    }

    /**
     * 点赞帖子
     * @param RequestInterface $request
     * @return mixed
     */
    public function like($uid, $id)
    {
        try {
            $userInfoService = new UserInfoService();
            $userLikeService = new UserLikeService();

            $userLikeService->data = [
                'user_id' => $uid,
                'post_id' => $id,
                'created_at' => time(),
                'updated_at' => time(),
            ];
            $this->condition = ['id' => $id];

            // 获取userId
            $userId = $this->multiTableJoinQueryBuilder()->value('user_id');

            Db::beginTransaction();

            // 插入
            $userLikeService->insert();

            //更新帖子点赞数 +1
            $this->multiTableJoinQueryBuilder()->increment('like_total');

            //更新帖子用户获赞数
            $userInfoService->multiTableJoinQueryBuilder()->increment('like_num', 1, ['user_id' => $userId]);

            //更新我点赞数
            $userInfoService->multiTableJoinQueryBuilder()->increment('my_like_num', 1, ['user_id' => $userId]);

            Db::commit();
            return true;

        } catch (\Exception $e) {
            Db::rollBack();
            throw new BusinessException((int)$e->getCode(), '操作失败');
        }
    }

    /**
     * 取消点赞帖子
     * @param RequestInterface $request
     * @return mixed
     */
    public function cancelLike($uid, $id)
    {
        try {
            $userInfoService = new UserInfoService();
            $userLikeService = new UserLikeService();

            // 获取userId
            $userId = $this->multiTableJoinQueryBuilder()->value('user_id');

            Db::beginTransaction();
            $userLikeService->condition = [
                ['user_id' => $uid],
                ['post_id' => $id],
            ];
            // 删除帖子点赞
            $userLikeService->delete();

            //更新帖子点赞数 -1
            $this->condition = ['id' => $id];
            $this->multiTableJoinQueryBuilder()->decrement('like_total');

            //更新帖子用户获赞数
            $userInfoService->multiTableJoinQueryBuilder()->decrement('like_num', 1, ['user_id' => $userId]);

            //更新我点赞数
            $userInfoService->multiTableJoinQueryBuilder()->decrement('my_like_num', 1, ['user_id' => $userId]);

            Db::commit();
            return true;

        } catch (\Exception $e) {
            Db::rollBack();
            throw new BusinessException((int)$e->getCode(), '操作失败');
        }
    }

    /**
     * 收藏帖子
     * @param RequestInterface $request
     * @return mixed
     */
    public function favorite($uid, $id)
    {
        try {
            $userFavoriteService = new UserFavoriteService();
            $userFavoriteService->condition = [
                'user_id' => $uid,
                'post_id' => $id,
            ];
            Db::beginTransaction();

            $userFavoriteService->store();

            //更新帖子收藏数 +1
            $this->condition = ['id' => $id];
            $this->multiTableJoinQueryBuilder()->increment('favorite_total');

            Db::commit();
            return true;

        } catch (\Exception $e) {
            Db::rollBack();
            throw new BusinessException((int)$e->getCode(), '操作失败');
        }
    }

    /**
     * 取消收藏帖子
     * @param RequestInterface $request
     * @return mixed
     */
    public function cancelFavorite($uid, $id)
    {
        try {
            $userFavoriteService = new UserFavoriteService();

            $userFavoriteService->data = [
                ['user_id' => $uid],
                ['post_id' => $id],
            ];
            Db::beginTransaction();

            $userFavoriteService->delete();

            //更新帖子收藏数 -1
            $this->condition = ['id' => $id];
            $this->multiTableJoinQueryBuilder()->decrement('favorite_total');

            Db::commit();
            return true;

        } catch (\Exception $e) {
            Db::rollBack();
            throw new BusinessException((int)$e->getCode(), '操作失败');
        }
    }

}