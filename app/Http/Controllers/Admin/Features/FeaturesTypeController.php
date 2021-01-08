<?php

namespace App\Http\Controllers\Admin\Features;

use App\Models\Feature_values;
use App\Models\Feature_types;
use App\Http\Controllers\Admin\Features\FeaturesAbstractController;
use App\Models\PropertyName;
use App\Models\PropertyValue;
use App\Models\Tag;
use App\Models\Property;
use App\Models\Value;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;

class FeaturesTypeController extends FeaturesAbstractController
{
    /**
     *  Возвращаем все характеристики
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $features = PropertyName::paginate(20);

        return view('admin.features.index', compact('features'));
    }

    /**
     *  Выводим форму создания харктеристики
     *
     * @return Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.features.create', [
            'features'=> []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * Созраняем характеристику
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $r = $request->all();
//        try {
//            $property = Property::create($r);
//            if( $r['value']){
//                $values = json_decode($r['value']);
//                if($values){
//                    foreach ($values as $feature){
//                        $featureValue = Value::create([
//                            'key' =>  $feature->key,
//                            'value' =>  $feature->value,
//                        ]);
//                        $property->prop_values()->save($featureValue);
//                    }
//                }
//            }
//            return response($property->title, 200);
//        }catch (\Exception $e){
//            return response($e->getMessage(), 500);
//        }

        $r = $request->all();
        try {
            $property = PropertyName::create($r);
            if( $r['value']){
                $values = json_decode($r['value']);
                if($values){
                    foreach ($values as $feature){
                        $featureValue = PropertyValue::create([
                            'key' =>  $feature->key,
                            'value' =>  $feature->value,
                        ]);
                        $property->propertyValues()->save($featureValue);
                    }
                }
            }
            return response($property->title, 200);
        }catch (\Exception $e){
            return response($e->getMessage(), 500);
        }

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
     */
    public function edit($id)
    {
        $property = PropertyName::find($id);
        return view('admin.features.edit', [
            "feature" => $property
        ]);
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
        // Получаем свойство
        $property = PropertyName::find($id);
        $r = $request->all();
        try {
            // Обновляем свойство
            $propertyUpdate = $property->update($r);
            // Проверяем что свойство обновленно и есть значения
            if( $r['value'] && $propertyUpdate){
                // получаем обновленное свойство
                $newProp = $property->first();
                $values = json_decode($r['value']);
                if($values){
                    // Удаляем все значения
                    $property->values()->delete();
                    foreach ($values as $feature){
                        // Создаём новое знаение
                        $featureValue = Value::create([
                            'key' =>  $feature->key,
                            'value' =>  $feature->value,
                        ]);
                        // Связываем со своством
                        $newProp->values()->save($featureValue);
                    }
                }
            }
            return response($newProp->title . ' Обнавлена', 200);
        }catch (\Exception $e){
            return response($e->getMessage(), 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Feature_types $feature
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(PropertyName $feature)
    {
        if($feature->values()) {
            try{
                $feature->values()->delete();
                $feature->delete();
                return redirect()->route('admin.features.index');
            }catch (\Exception $e){
                return response($e->getMessage(), 500);
            }
        }
    }

}
