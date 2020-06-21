<?php
declare(strict_types=1);

namespace App\Service\Admin;

use App\Exception\BusinessException;
use App\Service\Common\TagPostRelationService;
use App\Service\Common\UserTagService;

class TagService extends \App\Service\Common\TagService
{
    /**
     * 标签详情
     * @param $uid
     * @param $id
     * @return \Hyperf\Database\Model\Model|\Hyperf\Database\Query\Builder|object|null
     */
    public function getTagInfo($uid, $id)
    {
        try {
            $this->select = ['id', 'tag_name', 'is_hot', 'tag_type', 'used_count'];
            $this->condition = [
                ['id', '=', $id],
                ['status', '=', 1],
            ];
            $data = parent::show();

            $data['is_follow'] = 0;
            $userTagService = new UserTagService();
            $tagPostRelationService = new TagPostRelationService();

            if ($uid) {
                // 查询是否关注
                $userTagService->condition = [
                    ['user_id', '=', $uid],
                    ['tag_id', '=', $id]
                ];
                $exist = $userTagService->multiTableJoinQueryBuilder()->exists();
                if ($exist) {
                    $data['is_follow'] = 1;
                }
            }

            //标签下帖子数
            $tagPostRelationService->condition = ['tag_id' => $id];
            $postNum = $tagPostRelationService->multiTableJoinQueryBuilder()->count();
            $data['post_num'] = $postNum;

            //标签关注人数
            $userTagService->condition = ['tag_id' => $id];
            $followedNum = $userTagService->multiTableJoinQueryBuilder()->count();
            $data['followed_num'] = $followedNum;
            return $data;

        } catch (\Exception $e) {
            throw new BusinessException((int)$e->getCode(), $e->getMessage());
        }
    }

}