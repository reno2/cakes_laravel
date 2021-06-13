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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Models\Media;


class CommentController extends Controller
{


    protected $profileRepository;
    protected $adsRepository;
    protected $commentsRepository;

    public function __construct(
        CommentsRepository $commentsRepository,
        ProfileRepository $profileRepository,
        AdsRepository $adsRepository
    ) {
        $this->profileRepository  = $profileRepository;
        $this->adsRepository      = $adsRepository;
        $this->commentsRepository = $commentsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user            = Auth::user();
        $toUserQuestions = \DB::table('comments')
            ->join('articles', 'articles.id', '=', 'comments.article_id')
            ->join('profiles', 'profiles.user_id', '=', 'comments.from_user_id')
            ->leftJoin('media', 'media.model_id', '=', 'comments.article_id')
            ->select('articles.title',
                \DB::raw('COUNT(comments.from_user_id) AS count'))
            ->selectRaw('MAX(comments.created_at) AS last_date')
            ->selectRaw('ANY_VALUE(comments.id) as id')
            ->selectRaw('ANY_VALUE(articles.id) as article_id')
            ->selectRaw('ANY_VALUE(comments.parent_id ) as parent_id')
            ->selectRaw('ANY_VALUE(comments.from_user_id) as from_user_id')
            ->selectRaw('ANY_VALUE(comments.user_id) as user_id')
            ->selectRaw('ANY_VALUE(profiles.name) as name')
            ->where('comments.user_id', Auth::id())
            //->whereJsonContains('custom_properties->main', true)
            ->selectRaw('ANY_VALUE(media.file_name) as file_name')
            ->selectRaw('ANY_VALUE(media.id) as media_id')
            ->where('articles.user_id', Auth::id())
            ->groupBy('comments.article_id')
            ->orderBy('last_date', 'DESC')
            ->get();

        // dd($toUserQuestions);

        // нужно получить все поля
        // from_user_id = мой и recipient = null
        $userQuestions = \DB::table('comments')
            ->join('articles', 'articles.id', '=', 'comments.article_id')
            ->join('profiles', 'profiles.user_id', '=', 'comments.from_user_id')
            ->leftJoin('media', 'media.model_id', '=', 'comments.article_id')
            ->select('articles.title', 'comments.article_id',
                \DB::raw('COUNT(comments.article_id) AS article_id'))
            ->selectRaw('MAX(comments.created_at) AS last_date')
            ->selectRaw('ANY_VALUE(comments.id) as id')
            ->selectRaw('ANY_VALUE(comments.parent_id ) as parent_id')
            ->selectRaw('ANY_VALUE(comments.from_user_id) as from_user_id')
            ->selectRaw('ANY_VALUE(comments.user_id) as user_id')
            ->selectRaw('ANY_VALUE(profiles.name) as name')
            ->selectRaw('ANY_VALUE(comments.article_id) as article_id')
            ->selectRaw('ANY_VALUE(media.file_name) as file_name')
            ->selectRaw('ANY_VALUE(media.id) as media_id')
            ->where('comments.parent_id', 0)->where('comments.from_user_id', Auth::id())
            ->groupBy('article_id')
            ->orderBy('last_date', 'DESC')
            ->get();


        // Не прочитанные вопросы в которых текущий пользователь получатель и не владелец поста,
        // Получатель (recipient) ответил заполнив поле sender_read_at null
        $fromAuthorNotReadAnswer = \DB::table('comments')
            ->join('articles', 'articles.id', '=', 'comments.article_id')
            ->selectRaw('COUNT(comments.comment) AS count')
            ->selectRaw('ANY_VALUE(comments.user_id) as user_id')
            ->selectRaw('ANY_VALUE(comments.article_id) as article_id')
            ->where('comments.sender_read_at', null)
            ->where('comments.user_id', Auth::id())
            ->where('articles.user_id', "!=", Auth::id())
            ->groupBy('comments.article_id')
            ->get();


        if ($fromAuthorNotReadAnswer) {
            $fromAuthorNotReadAnswer = collect($fromAuthorNotReadAnswer)->mapWithKeys(function ($item) {
                return [$item->article_id => $item];
            });
        }
        // dd($fromAuthorNotReadAnswer);

        // Не прочитанные вопросы в которых текущий пользователь получатель,
        // а отправитель не прочитал (recipient)
        $toAuthorQuestionsNotAnswer = \DB::table('comments')
            ->selectRaw('COUNT(comments.comment) AS count')
            ->selectRaw('ANY_VALUE(comments.from_user_id) as from_user_id')
            ->selectRaw('ANY_VALUE(comments.article_id) as article_id')
            ->where('comments.recipient_read_at', null)
            ->where('comments.user_id', Auth::id())
            ->groupBy('comments.article_id')
            ->get();

        //dd($toAuthorQuestionsNotAnswer);
        $toAuthorQuestionsNotAnswer = collect($toAuthorQuestionsNotAnswer)->mapWithKeys(function ($item) {
            return [$item->article_id => $item];
        });


        return view('profile.comments.index', [
            'user'                       => $user,
            'userQuestions'              => $userQuestions,
            'toUserQuestions'            => $toUserQuestions,
            'toAuthorQuestionsNotAnswer' => $toAuthorQuestionsNotAnswer,
            'fromAuthorNotReadAnswer'    => $fromAuthorNotReadAnswer

        ]);
    }

    public function article(Request $request, $article_id)
    {
        $userId  = Auth::id();
        $article = \DB::table('articles')->where('id', $article_id)->first();
        $data    = [];
        // Текщий пользователь влделец поста
        if ($article->user_id === $userId) {
            $view     = 'profile.comments.users';
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
            $owner    = $article->user_id;
            $view     = 'profile.comments.comment';
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
                'owner'     => json_encode($this->getOwner($article->id)),
                'sender'    => json_encode($this->getSender()),
                'recipient' => json_encode($this->getRecipient($article->user_id)),
                'comment'   => $comment,
                'ads'       => $article,
                'sub'       => json_encode($comments),
                'userId'    => $userId,
                'userName'  => $userName = $this->profileRepository->getProfileNameByUserId($userId)
            ];

            $this->setAsReadRecipient($article);
        }

        return view($view, $data);
    }


    /**
     * Выводим ветку переписка владельца объявления
     *
     * @param int $article_id ид поста
     * @param int $user_id    ид задающего вопрос
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function comment(Request $request, $article_id, $user_id)
    {

        // Владелей поста
        $userId   = Auth::id();
        $userName = $this->profileRepository->getProfileNameByUserId($userId);
        $article  = \DB::table('articles')->where('id', $article_id)->first();
        $comments = \DB::table('comments')
            ->join('profiles', 'profiles.user_id', '=', 'comments.from_user_id')
            ->join('articles', 'articles.id', '=', 'comments.article_id')
            ->where('article_id', $article_id)
            ->where(function ($query) use ($userId) {
                $query->where('comments.from_user_id', $userId)
                    ->orWhere('comments.user_id', $userId);
            })->where(function ($query) use ($user_id) {
                $query->where('comments.from_user_id', $user_id)
                    ->orWhere('comments.user_id', $user_id);
            })
            ->select('comments.from_user_id', 'comments.id', 'comments.user_id', 'comments.comment',
                'comments.article_id', 'profiles.name', 'comments.created_at', 'comments.updated_at')
            ->orderBy('comments.created_at', 'ASC')
            ->get()
            ->toArray();



        //$this->setAsRead($article, $user_id);
        $this->setAsRead($article, $user_id);

        $profile = $this->profileRepository->getFirstProfileByUser($userId);
        $this->profileRepository->getProfileImg($profile);

        $comment = '';
        if ($comments) {
            $comment = $comments[0];
        }

        return view('profile.comments.comment', [
            'owner'     => json_encode($this->getOwner($article->id)),
            'sender'    => json_encode($this->getSender()),
            'recipient' => json_encode($this->getRecipient($user_id)),
            'comment'   => $comment,
            'ads'       => $article,
            'sub'       => json_encode($comments),
            'userId'    => $userId,
        ]);
    }

    public function getRecipient($user_id)
    {
        $profile     = $this->profileRepository->getFirstProfileByUser($user_id);
        $profileName = $profile->name;
        $profileAva  = $this->profileRepository->getProfileImg($profile);

        return ['user_id' => $user_id, 'name' => $profileName, 'ava' => $profileAva];
    }

    public function getSender()
    {
        $userId      = Auth::id();
        $profile     = $this->profileRepository->getFirstProfileByUser($userId);
        $profileName = $profile->name;

        return ['user_id' => $userId, 'name' => $profileName];
    }

    public function getOwner($articleId)
    {
        return $owner = \DB::table('articles')
            ->join('profiles', function ($join) {
                $join->on('profiles.user_id', '=', 'articles.user_id');
            })
            ->select('articles.user_id', 'profiles.name')
            ->where('articles.id', $articleId)
            ->get()
            ->toArray();
    }

    public function setAsRead($article, $askingUserId)
    {
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
    public function setAsReadRecipient($article)
    {
        $currentUserId = Auth::id();
        $comment       = tap(\DB::table('comments')
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
    public function store(CommentsRequest $request)
    {
        $request->validated();
        $request    = $request->toArray();
        $newComment = $this->commentsRepository->create($request);
        if ($newComment['code'] != 200)
            return response()->json(array('success' => false), 500);
        else
            return response()->json(array('success' => true, 'msg' => 'Ваш вопрос отправлен'), 200);
    }




    public function answer(Request $request)
    {
        $validated = $request->validate([
            'comment' => 'between:2,255|regex:/[а-яА-Я0-9 -.]+/',
        ]);
        $comment = $request->toArray();
        $commentData = [
            'parent_id'    => $comment['parent_id'],
            'from_user_id' => Auth::id(),
            'comment'      => $comment['comment'],
            'article_id'   => $comment['article_id'],
            'user_id'      => $comment['user_id']
        ];


        $article = \DB::table('articles')->where('id', $comment['article_id'])->first();

        // Если я владелец поста то ставим дату
        if($article->user_id == Auth::id())
            $commentData['recipient_read_at'] = Carbon::now();
        else
            $commentData['sender_read_at'] = Carbon::now();

        //dd($comment);
        $newComment = Comment::create( $commentData );
        if ($newComment) {
            return response()->json(array('success' => true, 'comment' => $newComment), 200);
        }
    }

    public function update(Request $request)
    {
        $commentData = $request->toArray();
        $comment = Comment::find($commentData['id']);

        if($comment){
            $commentToUpdate = [
                'from_user_id' =>  $commentData['from_user_id'],
                'parent_id' => $commentData['parent_id'],
                'sender_read_at'=> NULL,
                'user_id' => $commentData['user_id'],
                'comment' => $commentData['comment'],
                'approved' => $commentData['approved']?? 1
            ];
            try {
                $newComment = tap($comment)->update($commentToUpdate);
                return response()->json(array('success' => true, 'comment' => $newComment), 200);
            }catch( \Exception $e) {
                return response()->json(array('success' => false, 'error' => $e->getMessage()), 500);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        try{
            $comment->delete();
        }catch (\Exception $e){
            return redirect()->route('profile.ads.index')->with('errors',$e->getMessage());
        }
        return response()->json(array('success' => true), 200);

    }
}
