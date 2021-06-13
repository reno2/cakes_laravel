<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Category;
use App\Models\Moderate;
use App\Models\Settings;
use App\Models\User;
use App\Notifications\ModerateNotification;
use App\Notifications\PostCreatedNotification;
use App\Repositories\ProfileRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use App\Http\Requests\FileValidate;
use App\Models\PostImage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Factory|\Illuminate\View\View
     */
    private $count = 5;

    public function index(Request $request)
    {

        //MetaTag\
        if ($request->get('sort')) {
            $sort     = $request->get('sort');
            $articles = Article::orderBy('sort', $sort)->paginate(10);
        } else {
            $articles = Article::orderBy('created_at', 'desc')->paginate(10);
        }

        return view('admin.articles.index',

            compact('articles')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = \App\Models\Tag::all();

        //dd(Category::with('children')->where('parent_id', 0)->get());
        return view('admin.articles.switch_article', [
            'tags'       => $tags,
            'article'    => [],
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter'  => ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(FileValidate $request)
    {
        // Валидируем поля
        $validated = $request->validated();


        $inputs             = $request->all();
        $inputs['on_front'] = $request->input('on_front') ? true : false;

        // Удаяем из реквеста картинки для сохранения поста,
        // и последующей обработки


        if (isset($inputs['image'])) {
            $articleImagesCnt  = count($inputs['image']);
            unset($inputs['image']);
        } else $articleImagesCnt = 0;

        $article = Article::create($inputs);
        // Добавляем новый файл
        if ($request->hasfile('image')) {
            foreach ($request->file('image') as $image) {
                $name    = $image->getClientOriginalName();
                $fileUrl = Storage::url('images/' . $name);
                // Проверяем если количество файлов после редактирования
                // больше допустимого, то пропускаем
                if ($articleImagesCnt++ > $this->count) continue;
                // ToDo: написать проверку на дубли файла
                $path      = 'public/images/' . $name;
                $postImageModel = new PostImage;
                // Проверяем существует ли файл с таким именем,
                // если да, то не создаём, а используем существующий
                if (!Storage::disk('public')->exists('images/'.$name)) {
                    $image     = Image::make($image)->fit(450, 750, function ($constraint) {
                        $constraint->upsize();
                    }, 'center');
                    Storage::put($path, (string)$image->encode());
                    $url = Storage::url($path);
                }else{
                    $url = $fileUrl;
                }
                // Создаём запись в модели PostImage
                try {
                    $postImageModel->article_id = $article->id;
                    $postImageModel->name = md5($name);
                    $postImageModel->image_path = $url;
                    $postImageModel->save();

                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            }
        }
        // FilterGroups
        if ($request->input('attrs')):
            // Если есть фильтры, то удаляем все связи и обновляем новые
            $article->filterGroups()->delete();
            $article->filterValues()->delete();
            // Создаём новые связи
            $article->filterGroups()->attach(array_keys($request->input('attrs')));
            $article->filterValues()->attach($request->input('attrs'));
        endif;

        // Categories
        if ($request->input('categories')):
            $article->categories()->attach($request->input('categories'));
        endif;
        if ($request->input('tags')):
            $article->tags()->attach($request->input('tags'));
        endif;

        return redirect()->route('admin.article.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Article $article
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Article $article
     *
     * @return Factory|\Illuminate\View\View
     * @return Factory|\Illuminate\View\View
     */
    public function edit(Article $article)
    {
        $allRules = \App\Models\Settings::where('type', 'moderate_rules')->get();

        $moderateRules = [];
        if($article->moderateComments()->exists()) {
            $rule = $article->moderateComments()->first();
            $moderateRules['rule'] = unserialize($rule->rules);
            $moderateRules['moderate_text'] = $rule->message;
            $moderateRules['id'] = $rule->id;
        }

        $tags = \App\Models\Tag::all();
        $tags2 = [];
        foreach($tags as $tag){
            $tags2[$tag->id] = $tag->name;
        }
        return view('admin.articles.switch_article', [
            'article'    => $article,
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'tags'       => $tags,
            //'filter'     => $filters,
            'delimiter'  => '',
            'rules' => $allRules,
            'selectedRules' => $moderateRules
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Article             $article
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Article $article)
    {
        $this->validate($request, [
            'slug'  => Rule::unique('articles')->ignore($article->id, 'id'),
            'title' => 'required'
        ]);

        $inputsArray             = $request->all();
        $inputsArray['on_front'] = ($request->input('on_front')) ? true : false;
        $inputsArray['moderate'] = ($request->input('moderate')) ? true : false;

        $postImageAll = \App\Models\PostImage::where('article_id', $article->id)->get();
        $postImage  =  $postImageAll->pluck('image_path')->toArray();
        $articleImagesCnt        = count($postImage) ?? 0;
        $mainImageMd5 = ($inputsArray['main_image']) ?? false;
        $mainImage = false;
        // Обрабатываем редактирование файлов
        if (isset($postImage)) {
            foreach ($postImage as $image) {
                // Если есть старые файлы
                if (isset($inputsArray['old_files'])) {
                    // Если в массиве старых айлов нет текущего из базы данные
                    // И файл существует удаляем его
                    if (!in_array($image, $inputsArray['old_files'])) {
                        if (\File::exists(public_path($image))) {
                            \File::delete(public_path($image));
                            \App\Models\PostImage::where('image_path', $image)->delete();
                            $articleImagesCnt--;
                        }
                    }
                } else {
                    // Если массив старых файлов пуст, значит на фронте все файлы были удалены,
                    // Удаляем файлы из базы и сами файлы
                    if (\File::exists(public_path($image))) {
                        \File::delete(public_path($image));
                        \App\Models\PostImage::where('image_path', $image)->delete();
                        $articleImagesCnt--;
                    }
                }
            }
        }


        // Добавляем новый файл
        if ($request->hasfile('image')) {
            foreach ($request->file('image') as $image) {
                $name    = $image->getClientOriginalName();
                $fileUrl = Storage::url('images/' . $name);
                // Проверяем если количество файлов после редактирования
                // больше допустимого, то пропускаем
                if ($articleImagesCnt++ > $this->count) continue;
                // Если файл с таким имененм уже есть у поста то пропускаем
                if($postImage) {
                    if (in_array($fileUrl, $postImage)) continue;
                }
                $path      = 'public/images/' . $name;
                $postImageModel = new PostImage;
                // Проверяем существует ли файл с таким именем,
                // если да, то не создаём, а используем существующий
                if (!Storage::disk('public')->exists('images/'.$name)) {
                    $image     = Image::make($image)->fit(450, 750, function ($constraint) {
                        $constraint->upsize();
                    }, 'center');
                    Storage::put($path, (string)$image->encode());
                    $url = Storage::url($path);
                }else{
                    $url = $fileUrl;
                }
                // Создаём запись в модели PostImage
                try {
                    $postImageModel->article_id = $article->id;
                    $postImageModel->name = md5($name);
                    $postImageModel->image_path = $url;
                    if($postImageModel->save()){

                        $postImageAll[] = $postImageModel;
                    }
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            }
        }

        // Временное
        if($mainImageMd5) {
            foreach ($postImageAll as $row){
                if($mainImageMd5 == $row->name)
                    PostImage::where('id', $row->id)->update(['main' => true]);
                else
                    PostImage::where('id', $row->id)->update(['main' => false]);

            }
        }

        //dd($r);
        try {
            $update = $article->update($inputsArray);

            /** ===========================================================
             ===================Модерация================================
             **/
            if($inputsArray['moderate']){
                $article->moderateComments()->detach();
            }else {
                $moderateNode = [];
                if ($inputsArray['rule'] || $inputsArray['moderate_text']) {
                    $moderateNode = [
                        "rules" => serialize($inputsArray['rule']),
                        "message" => $inputsArray['moderate_text'],
                    ];
                }
                if (!empty($inputsArray['moderate_id'])) {
                    $mod = Moderate::find($inputsArray['moderate_id']);
                    $mod->update([
                            "rules" => serialize($inputsArray['rule']),
                            "message" => $inputsArray['moderate_text']
                        ]
                    );
                    $mod = $mod->refresh();
                } else {
                    $mod = \App\Models\Moderate::create([
                        "rules" => serialize($inputsArray['rule']),
                        "message" => $inputsArray['moderate_text'],
                    ])->fresh();
                }
                $ru = Settings::whereIn('id', $inputsArray['rule'])->get()->toArray();
                $userTo = User::where('id', $article->user_id)->get();
                $data = [
                    'event_name' => 'Модерация',
                    'url' => '/admin/article/'. $article->id .'/edit',
                    'title' => 'Ответ от модератора',
                    'message' => $inputsArray['moderate_text']
                ];
                Notification::send($userTo, new ModerateNotification($data));

                $article->moderateComments()->sync($mod->id);

            }

            /** ================================================================
            ===================Модерация=======================================
             **/


            // FilterGroups
            if ($request->input('attrs')):
                $article->filterGroups()->attach(array_keys($request->input('attrs')));
                $article->filterValues()->attach($request->input('attrs'));
            endif;

            //Tags
            $article->tags()->detach();
            if ($request->input('tags')):
                $article->tags()->attach($request->input('tags'));
            endif;

            //Categories
            $article->categories()->detach();
            if ($request->input('categories')):
                $article->categories()->attach($request->input('categories'));
            endif;

            if (array_key_exists('reload', $inputsArray)) {
                session()->flash('message', "Материал  изменен " . $article->title);
                $tags  = \App\Models\Tag::all();
                $tags2 = [];
                foreach ($tags as $tag) {
                    $tags2[$tag->id] = $tag->name;
                }

                return redirect()->route('admin.article.edit', [
                    'article'    => $article,
                    'categories' => Category::with('children')->where('parent_id', 0)->get(),
                    'tags'       => $tags,
                    //'main_image' => $mainImage,
                    'delimiter'  => ''
                ]);
            } else {
                session()->flash('message', "Материал  изменен " . $article->title);
                return redirect()->route('admin.article.index');
            }

        } catch (Exception $exception) {
            session()->flash('message', $exception->getMessage());
            return redirect()->route('admin.article.index');
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy( Article $article) {
        $article->categories()->detach();
        $article->delete();

        return redirect()->route('admin.article.index');
    }


    public function search( Request $request ) {
        $search   = trim(strip_tags($request->get('q')));
        $articles = Article::where('title', 'LIKE', '%' . $search . '%')
            ->paginate(10);

        return view('admin.articles.index',

            [
                'articles' => $articles,
                'title'    => 'Результаты поиска'
            ]
        );
    }

    public   function autocomplete( Request $request ) {
        $search = trim(strip_tags($request->get('q')));

        //return response()->json($request->all());
        $res = DB::table('articles')
            ->where('title', 'LIKE', '%' . $search . '%')
            ->get();

        return response()->json($res);

    }

    public function postUp(Request $request){
        $articleId =trim(strip_tags($request->get('id')));
        $article = DB::table('articles')
            ->where('id', $articleId)
            ->first();


        if(Carbon::parse($article->up_post)->lt(Carbon::now())){
            DB::table('articles')
            ->where('id', $articleId)
            ->update(['up_post' => Carbon::now()->addMinutes(10)]);
            $response = 'Ваше объявление поднято';
        }else{
            $response = 'Поднять можно через ' .
                Carbon::parse($article->up_post)->diff(Carbon::now())->format('%h часов %i минут %s секунд');
        }

        return response()->json($response, 200);
    }
}
