<?php
declare(strict_types=1);

namespace App\Service\Admin;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Utils\Common;

class UserService extends \App\Service\Common\UserService
{
    /**
     * @param int $page
     * @param int $limit
     * @param array $search
     * @return \Hyperf\Contract\PaginatorInterface|mixed
     */
    public function index(int $page = 1, int $limit = 10, $search = [])
    {
        $this->with = [
            'userInfo' => ['user_id', 'intro', 'like_num', 'follow_num', 'fans_num', 'post_num', 'my_like_num']
        ];
        return parent::index($page, $limit, $search);
    }

    /**
     * @param $post
     * @return bool|int
     * @throws \Exception
     */
    public function createUserInfo($post)
    {
        $this->select = ['id'];
        $this->condition = [['user_name', '=', $post['user_name']]];
        $userInfo = parent::show();
        if ($userInfo) {
            throw new BusinessException(ErrorCode::BAD_REQUEST, '用户名已经存在');
        }

        $salt = Common::generateSalt();
        $this->data = [
            'uuid'          => Common::generateSnowId(),
            'user_name'     => $post['user_name'],
            'real_name'     => $post['real_name'],
            'nick_name'     => $post['user_name'] . '_' . generate_random_string(6),
            'phone'         => $post['phone'],
            'avatar'        => '',
            'password'      => Common::generatePasswordHash($post['phone'], $salt),
            'salt'          => $salt,
            'status'        => $post['status'],
            'register_time' => time(),
            'register_ip'   => $post['ip'],
            'login_time'    => time(),
            'login_ip'      => $post['ip'],
            'created_at'    => time(),
            'updated_at'    => time()
        ];
        return parent::insert();
    }

    public function getPostList($uid)
    {
        $this->with = ['postList'];
        $this->condition = ['id' => $uid];
        return parent::index();
    }
}