<?php

namespace catchAdmin\member\controller;

use catcher\base\CatchRequest as Request;
use catcher\CatchResponse;
use catcher\base\CatchController;
use app\model\Message as messageModel;

class Message extends CatchController
{
    protected $messageModel;

    public function __construct(MessageModel $messageModel)
    {
        $this->messageModel = $messageModel;
    }

    /**
     * 布局
     * @time 2020年12月12日 16:24
     * @param Request $request 
     */
    public function layout(Request $request): \think\Response
    {
        $layout = $this->messageModel->getLayout();
        $layout['addConfig']['inline'] = false;
        $layout['editConfig']['inline'] = false;
        return CatchResponse::success($layout);
    }

    /**
     * 列表
     * @time 2020年12月12日 16:24
     * @param Request $request 
     */
    public function index(Request $request): \think\Response
    {
        return CatchResponse::paginate($this->messageModel->getList());
    }

    /**
     * 保存信息
     * @time 2020年12月12日 16:24
     * @param Request $request 
     */
    public function save(Request $request): \think\Response
    {
        return CatchResponse::success($this->messageModel->storeBy($request->post()));
    }

    /**
     * 读取
     * @time 2020年12月12日 16:24
     * @param $id 
     */
    public function read($id): \think\Response
    {
        return CatchResponse::success($this->messageModel->findBy($id));
    }

    /**
     * 更新
     * @time 2020年12月12日 16:24
     * @param Request $request 
     * @param $id
     */
    public function update(Request $request, $id): \think\Response
    {
        return CatchResponse::success($this->messageModel->updateBy($id, $request->post()));
    }

    /**
     * 删除
     * @time 2020年12月12日 16:24
     * @param $id
     */
    public function delete($id): \think\Response
    {
        return CatchResponse::success($this->messageModel->deleteBy($id));
    }
}
