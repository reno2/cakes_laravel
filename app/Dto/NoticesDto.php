<?php
namespace App\Dto;


use App\Repositories\CommentsRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class NoticesDto{

    // Репо Пользователя
    private UserRepository $userRepo;

    // Репо комментов
    private CommentsRepository $commentsRepo;

    // Проверка на авторизацию
    private bool $isAuth = false;

    // Ид пользователя
    private int $userId;

    // Все уведомления
    protected int $allCnt = 0;

    // Все прочитанные сообщения по чату
    protected int $allCommentsCnt = 0;

    // Не прочитанные уведомления
    protected int $allNoticesCnt = 0;

    // Не прочитанные вопросы
    protected int $commentNotReadAnswers = 0;

    // Не прочитанные ответы
    protected int $commentNotReadQuestions = 0;



    public function __construct () {
        if(!Auth::check()) return;

        $this->userId = Auth::id();
        $this->userRepo = new UserRepository();
        $this->commentsRepo =  new CommentsRepository();

        $this->setCommentCnt();
        $this->setNoticeCnt();
        $this->setAllCnt();
    }

    public function setCommentCnt(){
        $this->commentNotReadAnswers = $this->commentsRepo->notReadAnswers($this->userId);
        $this->commentNotReadQuestions = $this->commentsRepo->notReadQuestions($this->userId);
        if($this->commentNotReadAnswers > 0 || $this->commentNotReadQuestions > 0 ) {
            $this->allCommentsCnt = $this->commentNotReadAnswers + $this->commentNotReadQuestions;
        }
    }

    public function setNoticeCnt(){
        $this->allNoticesCnt = $this->userRepo->getNotReadModerateNoticeCount();
    }

    public function setAllCnt(){
        $this->allCnt = $this->allNoticesCnt + $this->allCommentsCnt;
    }


    public function getCommentsNotReadAnswers(){
        return $this->commentNotReadAnswers;
    }

    public function getCommentsNotReadQuestion(){
        return $this->commentNotReadQuestions;
    }


    /**
     * Получаем все
     * @return int|string
     */
    public function getAllCnt(){
        if($this->allCnt < 10) return $this->allCnt;
        return '9+';
    }

    /**
     * Получаем количество уведомлений
     * @return int
     */
    public function getAllNoticesCnt(){
        return $this->allNoticesCnt;
    }

    /**
     * Получаем количество вопросов
     * @return int
     */
    public function getAllCommentsCnt(){
        return $this->allCommentsCnt;
    }
}