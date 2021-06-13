<?php

namespace App\Http\Controllers\Admin;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $settings = Settings::paginate(10);
        $types = Settings::$types;
        return view('admin.settings.index', compact('settings', 'types'));
    }

    public function create()
    {
        return view('admin.settings.switch_settings', [
            'types' => Settings::$types,
            'parameter'=> []
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'value' => 'required|max:2000',
        ]);
        $setting = Settings::create($request->toArray());
        return redirect()->route('admin.settings.index');
    }

    public function edit(Settings $setting)
    {
        return view('admin.settings.switch_settings', [
            'types' => Settings::$types,
            'parameter'=> $setting
        ]);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'slug'  => Rule::unique('settings')->ignore($id, 'id'),
            'title' => 'required',
            'value' => 'required',
            'number' => 'numeric'
        ]);
        $setting = Settings::find($id);
        try{
            $setting->update($request->all());
        }catch (\Exception $e){
            return back()->withErrors( $e->getMessage())->withInput();
        }
        return redirect()->route('admin.settings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Settings $setting
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy( Settings $setting) {
        if($setting->nodes())
            $setting->nodes()->detach();
        $setting->delete();
        return redirect()->route('admin.settings.index');
    }

}
