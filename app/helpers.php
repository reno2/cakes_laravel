<?php

use App\Repositories\CommentsRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Storage;

if (!function_exists('helper_comment_owner_asked')) {
    function helper_comment_owner_asked ($article_owner, $user_to, $user_from) {
        $relations = [];
        $relations['owner'] = ($article_owner === (int)$user_to) ? $user_to : $user_from;
        $relations['asking'] = ($relations['owner'] === (int)$user_from) ? $user_to : $user_from;
        return $relations;
    }
}

/**
 * Получаем все пообщения
 * @return array
 */
function helper_getAllNotice () : array {
    $userRepo = new UserRepository();
    $commentsRepo = new CommentsRepository();

    // Сообщения о модерации
    $moderateNoticeCount = $userRepo->getNotReadModerateNoticeCount();

    // Сообщения о вопросах
    $commentsCount = $commentsRepo->notReadAnswers(Auth::id()) + $commentsRepo->notReadQuestions(Auth::id());

    //$noticeArray

    return ['moderateCount' => $moderateNoticeCount, 'commentsCount' => $commentsCount];
}

/**
 * Склонение слова в зависимости от числа
 * Принимает массим из 3 слов
 * @param $num
 * @param $words
 * @return mixed
 */
function helper_getNumWord (int $num, $words)
{
    $num = $num % 100;
    if ($num > 19) {
        $num = $num % 10;
    }
    switch ($num) {
        case 1:
        {
            return ($words[0]);
        }
        case 2:
        case 3:
        case 4:
        {
            return ($words[1]);
        }
        default:
        {
            return ($words[2]);
        }
    }
}


function helper_returnFakeImg($type = null)  {
    $path = Storage::url("images/defaults/cake.svg");
    if($type == 'ads_detail')
        $path = Storage::url("images/defaults/ads_default.svg");

    return $path;
}


function setLineBreaks($str){
    return str_replace(["\r\n", "\r", "\n"], '<br>', $str);
}