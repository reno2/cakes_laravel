<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Http\File;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request  $request
		 *
		 * @return \Illuminate\Http\JsonResponse
		 */
    public function add(Request $request)
    {
        $r = $request->all();
      dd($r);

//		    $filename = time().$request->file('image')->getClientOriginalName();
//		    $path = 'public/categories/' .  $filename;
//
//            // $image = Image::make($request->file('image'))->fit(300, 300);
//            $image= Image::make($request->file('image'))->fit(300, 300, function ($constraint) {
//                 $constraint->upsize();
//            }, 'center');
//
//		    $bb =  Storage::put($path, (string) $image->encode());
//
//		    if($bb)
//				{
//						$url = Storage::url($path);
//				    return response()->json([
//						    'image' => 	 $url
//				    ]);
//				}
    }

		public function upload(Request $request){
				$errorMessage = 'Не удалось загрузить изображение';
				if($request->hasFile('upload')) {
						$translite = Str::slug(time().$request->file('upload')->getClientOriginalName());

						//$filename = time().$request->file('upload')->getClientOriginalName();
						$path = Storage::putFileAs( 'public/article', $request->file('upload'), $translite);
						if($path){
								$url = Storage::url($path);
								$res = "window.parent.CKEDITOR.tools.callFunction(1,'{$url}','Файл загружен')";
						}else{
								$res = 'alert(Не удалось загрузить файл)';
						}
				}else{
						$res = 'alert(Файл не выбран)';
				}
				@header('Content-type: text/html; charset=utf-8');
				echo '<script>'.$res.'</script>';
		}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
