<?php

namespace App\Http\Controllers\Profile;


use App\Http\Requests\AdsRequest;
use App\Http\Requests\CommentsRequest;
use App\Models\Article;
use App\Models\Comment;
use App\Repositories\AdsRepository;
use App\Repositories\CommentsRepository;
use Carbon\Carbon;
use App\Repositories\ProfileRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Spatie\MediaLibrary\Models\Media;
use App\Events\CommentEvent;
use Throwable;

class CommentController extends Controller
{


    protected $profileRepository;
    protected $adsRepository;
    protected $commentsRepository;

    public function __construct (
        CommentsRepository $commentsRepository,
        ProfileRepository $profileRepository,
        AdsRepository $adsRepository
    ) {
        $this->profileRepository = $profileRepository;
        $this->adsRepository = $adsRepository;
        $this->commentsRepository = $commentsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index () {
        $user = Auth::user();


       // dd($this->commentsRepository->getNotRead(Auth::id(), 'sender_read_at'));
        return view('profile.comments.index', [

            // Новый метод
            'toUserQuestions' => $this->commentsRepository->toMeComments(),
            'user' => $user,
            'userQuestions' => $this->commentsRepository->myComments(),
            'notReadQuestions' => $this->commentsRepository->notReadQuestions(Auth::id()),
            'notReadAnswers' => $this->commentsRepository->notReadAnswers(Auth::id()),
//            'not_read' => [
//                'not_read_to_me'   => $notReadToMe,
//                'not_read_from_me' => $notReadFromMe,
//                'not_read_count'   => $notReadToMe + $notReadFromMe
//            ]

        ]);
    }

    public function article (Request $request, $article_id) {
        $userId = Auth::id();
        $article = \DB::table('articles')->where('id', $article_id)->first();
        $data = [];
        // Текщий пользователь влделец поста
        if ($article->user_id === $userId) {
            $view = 'profile.comments.users';
            $comments = \DB::table('comments')
                           ->join('profiles', 'profiles.user_id', '=', 'comments.from_user_id')
                           ->join('articles', 'articles.id', '=', 'comments.article_id')
                           ->where('comments.article_id', $article_id)
                           ->where('comments.user_id', $article->user_id)
                           ->select(\DB::raw('COUNT(comments.from_user_id) AS from_user_questions'))
                           ->selectRaw('ANY_VALUE(profiles.name) as name')
                           ->selectRaw('ANY_VALUE(profiles.image) as image')
                           ->selectRaw('ANY_VALUE(comments.user_id) as user_id')
                           ->selectRaw('ANY_VALUE(comments.from_user_id) as from_user_id')
                           ->selectRaw('ANY_VALUE(articles.title) as title')
                           ->selectRaw('MAX(comments.created_at) AS last_date')
                           ->selectRaw('ANY_VALUE(comments.article_id) as article_id')
                           ->selectRaw('ANY_VALUE(comments.id) as id')
                           ->groupBy('comments.from_user_id')
                           ->orderBy('last_date', 'ASC')
                           ->get();

            //dd($comments);
            $data = ['data' => $comments];

        } else {
            // Текущий пользователь не владелец поста
            $owner = $article->user_id;
            $view = 'profile.comments.comment';
            $comments = \DB::table('comments')
                           ->join('profiles', 'profiles.user_id', '=', 'comments.from_user_id')
                           ->join('articles', 'articles.id', '=', 'comments.article_id')
                           ->where('article_id', $article_id)
                           ->where(function ($query) use ($userId) {
                               $query->where('comments.from_user_id', $userId)
                                     ->orWhere('comments.user_id', $userId);
                           })->where(function ($query) use ($owner) {
                    $query->where('comments.from_user_id', $owner)
                          ->orWhere('comments.user_id', $owner);
                })
                           ->select('comments.from_user_id', 'comments.id', 'comments.user_id', 'comments.comment',
                               'comments.article_id', 'profiles.name', 'comments.created_at', 'comments.updated_at')
                           ->orderBy('comments.created_at', 'ASC')
                           ->get()
                           ->toArray();

            $comment = '';
            if ($comments) {
                $comment = $comments[0];
            }
            $data = [
                'owner' => json_encode($this->getOwner($article->id)),
                'sender' => json_encode($this->getSender()),
                'recipient' => json_encode($this->getRecipient($userId)),
                'comment' => $comment,
                'ads' => $article,
                'sub' => json_encode($comments),
                'userId' => $userId,
                'userName' => $userName = $this->profileRepository->getProfileNameByUserId($userId),
            ];

            $this->setAsReadRecipient($article);
        }

        return view($view, $data);
    }


    /**
     * Выводим ветку переписка владельца объявления
     *
     * @param int $room_id ид комнаты

     *
     * @return Factory|View
     */

    public function comment ($room_id) {
        // Получаем Id владельца поста
        $userId = Auth::id();
        $data = $this->commentsRepository->getRoomWithRelations($room_id);
        $comments = Room::find($room_id)->comments->toArray();


        $this->commentsRepository->murkAsRead($room_id,
            ($data['owner_id'] === Auth::id()) ? 'recipient_read_at' : 'sender_read_at');




        $users = [
            $data['owner_id'] => array_merge(
                $data["ads_owner"],
                [
                    'name' => $data["ads_owner"]['profiles'][0]['name'],
                    'image' => $data["ads_owner"]['profiles'][0]['image']
                ]),
            $data['asked_id'] => array_merge(
                $data["ads_asked"],
                [
                    'name' => $data["ads_asked"]['profiles'][0]['name'],
                    'image' => $data["ads_asked"]['profiles'][0]['image']
                ])
        ];

        return view('profile.comments.comment', [
            'profile' => $data['ads_asked'],
            'users' => json_encode($users),
            'user' => $userId,
            'comment' => $comments[0],
            'ads' =>  $data['ads'],
            'sub' => json_encode($comments),
            'room' => $room_id,
        ]);

    }

    public function getRecipient ($user_id) {
        $profile = $this->profileRepository->getFirstProfileByUser($user_id);
        $profileName = $profile->name;
        return ['user_id' => $user_id, 'name' => $profileName, 'ava' => $profile->image];
    }

    public function getSender () {
        $userId = Auth::id();
        $profile = $this->profileRepository->getFirstProfileByUser($userId);
        $profileName = $profile->name;

        return ['user_id' => $userId, 'name' => $profileName];
    }

    public function getOwner ($articleId) {
        return $owner = \DB::table('articles')
                           ->join('profiles', function ($join) {
                               $join->on('profiles.user_id', '=', 'articles.user_id');
                           })
                           ->select('articles.user_id', 'profiles.name')
                           ->where('articles.id', $articleId)
                           ->get()
                           ->toArray();
    }

    public function setAsRead ($article, $askingUserId) {
        $currentUserId = Auth::id();
        if ($article->user_id == $currentUserId) {
            $comment = tap(\DB::table('comments')
                              ->where('comments.article_id', $article->id))
                ->where('from_user_id', $askingUserId)
                ->update(['recipient_read_at' => Carbon::now()]);
        }
    }

    /*
     * $article model модель материала
     * $senderUserId ind ид пользователя который задаёт вопрос
     * Помечаем сообщения пользователя который задавал вопрос и перешёл в ветку
     * как прочитыные
     */
    public function setAsReadRecipient ($article) {
        $currentUserId = Auth::id();
        $comment = tap(\DB::table('comments')
                          ->where('comments.article_id', $article->id))
            ->update(['sender_read_at' => Carbon::now()]);

    }

    /**
     * Добавляет комментарий с фронта
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store (CommentsRequest $request) {
        $request->validated();
        $request = $request->toArray();
       try{
            $newComment = $this->commentsRepository->create($request);
            return response()->json(array ('success' => true, 'msg' => 'Ваш вопрос отправлен'), 200);
        } catch (\Exception  $e) {
           Log::debug($e->getMessage());
            return response()->json(array ('success' => false, 'msg' => $e->getMessage()), 200);
        }
    }


    /**
     * Создание комментария из комнаты
     * @param Request $request
     * @return JsonResponse
     */
    public function answer (Request $request) {
        $validated = $request->validate([
            'comment' => 'between:2,255|regex:/^[а-яa-z0-9 .]+$/i',
        ]);
        $comment = $request->toArray();
        $commentData = [
            'parent_id' => $comment['parent_id'],
            'from_user_id' => Auth::id(),
            'comment' => $comment['comment'],
            'article_id' => $comment['article_id'],
            'user_id' => $comment['user_id'],
            'room' => $comment['room']
        ];


        $article = \DB::table('articles')->where('id', $comment['article_id'])->first();

        // Если я владелец поста то ставим дату
        if ($article->user_id == Auth::id()) {
            $commentData['recipient_read_at'] = Carbon::now();
        } else {
            $commentData['sender_read_at'] = Carbon::now();
        }

        //dd($comment);
        $newComment = Comment::create($commentData);
        if ($newComment) {
            return response()->json(array ('success' => true, 'comment' => $newComment), 200);
        }
    }

    public function update (Request $request) {
        $commentData = $request->toArray();
        $comment = Comment::find($commentData['id']);

        if ($comment) {
            $commentToUpdate = [
                'from_user_id' => $commentData['from_user_id'],
                'parent_id' => $commentData['parent_id'],
                'sender_read_at' => NULL,
                'user_id' => $commentData['user_id'],
                'comment' => $commentData['comment'],
                'approved' => $commentData['approved'] ?? 1,
            ];
            try {
                $newComment = tap($comment)->update($commentToUpdate);
                return response()->json(array ('success' => true, 'comment' => $newComment), 200);
            } catch (\Exception $e) {
                return response()->json(array ('success' => false, 'error' => $e->getMessage()), 500);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy ($id, Request $request) {
        $comment = Comment::find($id);
        try {
            $comment->delete();
        } catch (\Exception $e) {
            return redirect()->route('profile.ads.index')->with('errors', $e->getMessage());
        }
        return response()->json(array ('success' => true), 200);

    }
}
