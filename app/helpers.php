<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('helper_comment_owner_asked')) {
    function helper_comment_owner_asked ($article_owner, $user_to, $user_from) {
        $relations = [];
        $relations['owner'] = ($article_owner === (int)$user_to) ? $user_to : $user_from;
        $relations['asking'] = ($relations['owner'] === (int)$user_from) ? $user_to : $user_from;
        return $relations;
    }
}

