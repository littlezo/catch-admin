<?php

namespace catchAdmin\member\controller;

use catcher\base\CatchRequest as Request;
use catcher\CatchResponse;
use catcher\base\CatchController;
use app\model\Member as memberModel;

class Inside extends CatchController
{
    protected $memberModel;

    public function __construct(MemberModel $memberModel)
    {
        $this->memberModel = $memberModel;
    }

    /**
     * 布局
     * @time 2020年12月09日 05:56
     * @param Request $request 
     */
    public function layout(Request $request): \think\Response
    {
        return CatchResponse::success($this->memberModel->getLayout());
    }

    /**
     * 列表
     * @time 2020年12月09日 05:56
     * @param Request $request 
     */
    public function index(Request $request): \think\Response
    {
        return CatchResponse::paginate($this->memberModel->getList(1));
    }

    /**
     * 保存信息
     * @time 2020年12月09日 05:56
     * @param Request $request 
     */
    public function save(Request $request): \think\Response
    {
        return CatchResponse::success($this->memberModel->storeBy($request->post()));
    }

    /**
     * 读取
     * @time 2020年12月09日 05:56
     * @param $id 
     */
    public function read($id): \think\Response
    {
        return CatchResponse::success($this->memberModel->findBy($id));
    }

    /**
     * 更新
     * @time 2020年12月09日 05:56
     * @param Request $request 
     * @param $id
     */
    public function update(Request $request, $id): \think\Response
    {
        return CatchResponse::success($this->memberModel->updateBy($id, $request->post()));
    }

    /**
     * 删除
     * @time 2020年12月09日 05:56
     * @param $id
     */
    public function delete($id): \think\Response
    {
        return CatchResponse::success($this->memberModel->deleteBy($id));
    }
}
