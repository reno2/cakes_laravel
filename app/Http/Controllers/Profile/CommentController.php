<?php

namespace App\Http\Controllers\Profile;

use App\Http\Requests\AdsRequest;
use App\Models\Article;
use App\Models\Comment;
use Carbon\Carbon;
use App\Repositories\ProfileRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{


    protected $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $toUserQuestions = \DB::table('comments')
            ->join('articles', 'articles.id', '=', 'comments.article_id')
            ->join('profiles', 'profiles.user_id', '=', 'comments.from_user_id')
            ->select('articles.title',
                \DB::raw('COUNT(comments.article_id) AS count'))

            ->selectRaw('MAX(comments.created_at) AS last_date')
            ->selectRaw('ANY_VALUE(comments.id) as id')
            ->selectRaw('ANY_VALUE(articles.id) as article_id')
            ->selectRaw('ANY_VALUE(comments.parent_id ) as parent_id')
            ->selectRaw('ANY_VALUE(comments.from_user_id) as from_user_id')
            ->selectRaw('ANY_VALUE(comments.user_id) as user_id')
            ->selectRaw('ANY_VALUE(profiles.name) as name')

            ->where('comments.user_id', Auth::id())
            ->where('articles.user_id', Auth::id())
            ->groupBy('comments.article_id')
            ->orderBy('last_date', 'DESC')
            ->get();


        $userQuestions = \DB::table('comments')
            ->join('articles', 'articles.id', '=', 'comments.article_id')
            ->join('profiles', 'profiles.user_id', '=', 'comments.from_user_id')
            ->select('articles.title', 'comments.article_id',
                \DB::raw('COUNT(comments.article_id) AS article_id'))
            ->selectRaw('MAX(comments.created_at) AS last_date')
            ->selectRaw('ANY_VALUE(comments.id) as id')
            ->selectRaw('ANY_VALUE(comments.parent_id ) as parent_id')
            ->selectRaw('ANY_VALUE(comments.from_user_id) as from_user_id')
            ->selectRaw('ANY_VALUE(comments.user_id) as user_id')
            ->selectRaw('ANY_VALUE(profiles.name) as name')
            ->selectRaw('ANY_VALUE(comments.article_id) as article_id')
            ->where('comments.parent_id', 0)->where('comments.from_user_id', Auth::id())
            ->groupBy('article_id')
            ->orderBy('last_date', 'DESC')
            ->get();


        //dd($toUserQuestions);
        return view('profile.comments.index', [
            'user' => $user,
            'userQuestions' => $userQuestions,
            'toUserQuestions' => $toUserQuestions

        ]);
    }
    public function article(Request $request, $article_id)
    {
        $userId = Auth::id();
        $article = \DB::table('articles')->where('id', $article_id)->first();
        $data = [];
        // Текщий пользователь влделец поста
       if($article->user_id ===  $userId){
           $view = 'profile.comments.users';
           $comments = \DB::table('comments')
               ->join('profiles', 'profiles.user_id', '=', 'comments.from_user_id')
               ->join('articles', 'articles.id', '=', 'comments.article_id')
               ->where('comments.article_id', $article_id)
               ->where('comments.user_id', $article->user_id)
               ->select( \DB::raw('COUNT(comments.from_user_id) AS from_user_questions'))
               ->selectRaw('ANY_VALUE(profiles.name) as name')
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

       }else{
           // Текущий пользователь не владелец поста
           $view = 'profile.comments.comment';
           $comments =  \DB::table('comments')
               ->join('profiles', 'profiles.user_id', '=', 'comments.from_user_id')
               ->join('articles', 'articles.id', '=', 'comments.article_id')
               ->where('article_id', $article_id)
               ->whereIn('comments.from_user_id', [$userId, $article->user_id])
               ->select('comments.from_user_id', 'comments.id', 'comments.user_id', 'comments.comment', 'comments.article_id', 'profiles.name', 'comments.created_at')
               ->orderBy('comments.created_at', 'ASC')
               ->get()
               ->toArray();

           //dd($comments);
           //dd($this->getRecipient($article->user_id));

           $data = [
               'owner'     => json_encode($this->getOwner($article->id)),
               'sender'    => json_encode($this->getSender()),
               'recipient' => json_encode($this->getRecipient($article->user_id)),
               'comment'   => $comments[0],
               'ads'       => $article,
               'sub'       => json_encode($comments),
               'userId'    => $userId,
               'userName'  => $userName = $this->profileRepository->getProfileNameByUserId($userId)
           ];

       }

        return view($view, $data);
    }

    public function comment(Request $request, $article_id, $user_id)
    {

        // делаем детку прочитанной
        // $comment = tap(\DB::table('comments')
        // ->where('comments.id',  $comment_id))
        // ->update(['read_at' => Carbon::now()])
        // ->first();

        $userId   = Auth::id();
        $userName = $this->profileRepository->getProfileNameByUserId($userId);
        $article = \DB::table('articles')->where('id', $article_id)->first();
        $comments =  \DB::table('comments')
            ->join('profiles', 'profiles.user_id', '=', 'comments.from_user_id')
            ->join('articles', 'articles.id', '=', 'comments.article_id')
            ->where('article_id', $article_id)
            ->where('comments.from_user_id',  $user_id)
            ->where('comments.user_id',  $userId)
            ->select('comments.from_user_id', 'comments.id', 'comments.user_id', 'comments.comment', 'comments.article_id', 'profiles.name', 'comments.created_at')
            ->orderBy('comments.created_at', 'ASC')
            ->get()
            ->toArray();

       //dd($this->getOwner($article->id));
        return view('profile.comments.comment', [
            'owner'    => json_encode($this->getOwner($article->id)),
            'sender' => json_encode($this->getSender()),
            'recipient' => json_encode($this->getRecipient($user_id)),
            'comment'  => $comments[0],
            'ads'      => $article,
            'sub'      => json_encode($comments),
            'userId'   => $userId,
        ]);
    }

    public function getRecipient($user_id){

        $profileName = $this->profileRepository->getProfileNameByUserId($user_id);
        return ['user_id'=>$user_id, 'name'=>$profileName];
    }
    public function getSender(){
        $userId = Auth::id();
        $profileName = $this->profileRepository->getProfileNameByUserId($userId);
        return ['user_id'=>$userId, 'name'=>$profileName];
    }
    public function getOwner($articleId){
        return $owner = \DB::table('articles')
            ->join('profiles', function ($join) {
                $join->on('profiles.user_id', '=', 'articles.user_id');
            })
            ->select('articles.user_id', 'profiles.name')
            ->where('articles.id', $articleId)
            ->get()
            ->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $comment    = $request->toArray();
        $newComment = Comment::create([
            'from_user_id' => $comment['from_user_id'],
            'parent_id'    => 0,
            'user_id'      => $comment['user_id'],
            'article_id'   => $comment['article_id'],
            'comment'      => $comment['question']

        ]);
        if ($newComment) {
            return response()->json(array('success' => true), 200);
        }

    }

    public function update(Request $request)
    {

        $comment = $request->toArray();
        //dd($comment);
        $newComment = Comment::create([
            'parent_id'    => $comment['parent_id'],
            'from_user_id' => Auth::id(),
            'comment'      => $comment['comment'],
            'article_id'   => $comment['article_id'],
            'user_id'      => $comment['user_id']
        ]);
        if ($newComment) {
            return response()->json(array('success' => true, 'comment' => $newComment), 200);
        }
        //dd($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
