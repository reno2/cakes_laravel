<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\CoreRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Article as Model;

use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\Models\Media;
use App\Models\Profile;

class CommentsRepository extends CoreRepository
{
    /**
     *
     * @param $user_from
     * @param $article_id
     */
    public function getToUserFirstBranchId($user_from, $article_id){
        return \DB::table('comments')
            ->select('id')
            ->where('comments.article_id', $article_id)
            ->where('comments.from_user_id', $user_from)
            ->where('comments.parent_id', 0)
            ->first();
    }

    /*  Создание нового комментария с фронта
     * @param array $request - Объект запроса
     * @return Comment|Array - возвращает лтбо новый комментарий либо массив с ошибкой
     */
    public function create($request){
        try {
            $comment = \DB::table('comments')
                ->where('comments.article_id', $request['article_id'])
                ->where('comments.from_user_id', $request['from_user_id'])
                ->select(\DB::raw('COUNT(comments.from_user_id) AS count'))
                ->selectRaw('MAX(comments.created_at) AS last_date')
                ->selectRaw('ANY_VALUE(comments.id) as id')
                ->groupBy('comments.article_id')
                ->orderBy('last_date', 'DESC')
                ->first();

            if(!$comment) $commentId = 0;
            else $commentId = $comment->id;

            $newComment = Comment::create([
                'from_user_id' => $request['from_user_id'],
                'parent_id'    => $commentId,
                'sender_read_at' => Carbon::now(),
                'user_id'      => $request['user_id'],
                'article_id'   => $request['article_id'],
                'comment'      => $request['question']
            ]);

            return ['comment' => $newComment, 'code' => 200];
        }catch (\Throwable $e){
            return ['error' => $e->getMessage(), 'code' => $e->getCode()];
        }
    }







    function fail($msg = 'Ошибка сохранения файла'){
        throw new \Exception($msg);
    }

    /*
      * @return string
      */
    protected function getModelClass()
    {
        return Model::class;
    }
}
