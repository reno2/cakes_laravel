<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Seo\SeometaFacade;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Article;

class SearchController extends Controller
{

    public function fulltextSearch(Request $request, SearchService $searchService){
        $term =trim(strip_tags($request->get('term')));

        $items = [];
        $title = "Результатов по запросу $term не найдено.";
        if($term) {
            try{
                list('items' => $items, 'title' => $title) = $searchService->getByQuery($term);
            }catch (\Exception $e){

            }

        }

        SeometaFacade::setStaticTag('title', 'Результаты поиска');
        SeometaFacade::setStaticTag('h1', $title);

        return view('search', [
            'items' => $items,
            'title' => $title
        ]);
    }

    public function index(Request $request){
        $search =trim(strip_tags($request->get('q')));
        if($search)
        {
            $res = Article::where('title', 'LIKE', '%' . $search . '%')
                ->get();
        }else{
            $res = null;
        }
        return view('blog.search', compact('res', 'search'));
    }
    public function search(Request $request){
        $search =trim(strip_tags($request->get('term')));

        //return response()->json($request->all());
        $res = DB::table('articles')
            ->where('title', 'LIKE', '%'.$search.'%')
            ->get();
        return response()->json($res);

    }
    public function autocomplete(Request $request){
        $search =$request->get('term');
        $res = DB::table('articles')
            ->where('title', 'LIKE', '%'.$search['term'].'%')
            ->get()->toArray();



        $to= [];
        if(count($res)>0)
        {
            foreach ($res as $key => $item)
            {

                $to[$key]['id']   = $item->id;
                $to[$key]['text'] = $item->title;

            }
            $r = response()->json($to);
        }else{
            $r = response()->json([]);
        }

        return $r;

    }



    public function searchAuthor( Request $request ) {
       $search = trim(strip_tags($request->get('term')));

        //return response()->json($request->all());
        $arRes = DB::table('users')
                ->select('id', 'email')
                 ->where('email', 'LIKE', '%' . $search . '%')
                 ->get();
        return response()->json(
            ['items' => $arRes]
        );

    }

}
