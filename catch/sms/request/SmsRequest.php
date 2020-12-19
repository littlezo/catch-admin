<?php

namespace catchAdmin\sms\request;

use catcher\base\CatchRequest;

class SmsRequest extends CatchRequest
{
    protected $needCreatorId = true;

    protected function rules(): array
    {
        // TODO: Implement rules() method.
        return [];
    }

    protected function message(): array
    {
        // TODO: Implement message() method.
        return [];
    }
}
