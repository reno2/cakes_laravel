<?php

use App\Repositories\CommentsRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;

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
    $moderateNoticeCount = $userRepo->getNotReadModerateNoticeCount();
    $commentsCount = $commentsRepo->notReadAnswers(Auth::id()) + $commentsRepo->notReadQuestions(Auth::id());
    return ['moderateCount' => $moderateNoticeCount, 'commentsCount' => $commentsCount];
}
