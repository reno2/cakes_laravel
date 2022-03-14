<?php

namespace App\Http\Controllers\Admin;


use App\Media\LocalMedia;
use App\Media\MediaInterface;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Mockery\Exception;
use Session;

class TagController extends Controller
{
    public $tagService;
    public function __construct()
    {
        $this->tagService = new TagService();
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param TagService $tagService
     * @return Factory|View
     */
    public function index()
    {

        $tags = $this->tagService->getAll();

        return view('admin.tags.index', compact('tags'));

    }


    /**
     * @return Factory|View
     */
    public function create()
    {

        return view('admin.tags.create', [
            'tag'=> []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255|unique:tags',
        ]);

        try {
            $this->tagService->createTag($request);
            Session::flash('success', 'тег создан');

        } catch (\Exception $e) {
            return back()->withErrors( $e->getMessage())->withInput();
        }

        return redirect()->route('admin.tags.index');

    }

    /**
     * @param Tag $tag
     * @return Response
     */
    public function show(Tag $tag)
    {

        return view('admin.tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Tag $tag
     * @return Factory|View
     */
    public function edit(Tag $tag)
    {
        $articles = $tag->articles;
        $tag = $this->tagService->getForEdit($tag);
        return view('admin.tags.edit', compact('tag', 'articles'));
    }

    /**
     * Обновление тэга
     *
     * @param Request $request
     * @param Tag $tag
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Tag $tag)
    {

        $this->validate($request, [
            'slug' => Rule::unique('tags')->ignore($tag->id, 'id'),
            'title' => 'required'
        ]);


        try{
            $this->tagService->updateTag($tag, $request);
            session()->flash('message', "Тег  изменен " . $tag->title);
        }catch (Exception $exception){
            session()->flash('message', $exception->getMessage());
            return redirect()->route('admin.tags.index');
        }

        return redirect()->route('admin.tags.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $tag
     * @return Response
     * @throws \Exception
     */
    public function destroy(Tag $tag)
    {

        $this->tagService->deleteFilesAndRelation($tag);
        return redirect()->route('admin.tags.index');
    }
}
