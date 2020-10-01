<?php


namespace App\Helpers;


class ContactHelper
{
    public function messagesSI()
    {
        return [
            'email.required' => trans('messages.emailRequired'),
            'fullname.required' => trans('messages.fullnameRequired'),
            'fullname.min' => trans('messages.fullnameTooShort'),
            'message.required' => trans('messages.messageRequired'),
            'message.min' => trans('messages.messageTooShort'),
        ];
    }

    public function messagesEN()
    {
        return [
            'email.required' => trans('messages.emailRequiredEN'),
            'fullname.required' => trans('messages.fullnameRequiredEN'),
            'fullname.min' => trans('messages.fullnameTooShortEN'),
            'message.required' => trans('messages.messageRequiredEN'),
            'message.min' => trans('messages.messageTooShortEN'),
        ];
    }
}
