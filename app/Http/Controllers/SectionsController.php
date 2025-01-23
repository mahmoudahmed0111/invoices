<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = sections::all();
        return view('sections.sections',compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_name' => 'required|unique:sections|max:255',
            'description' => 'required'
        ],[
            'section_name.required' => 'يرجي ادخال اسم القسم',
            'section_name.unique' => ' اسم القسم موجود بالفعل',
            'description.required' => 'يرجي ادخال البيانات',
        ]);

        sections::create([
            'section_name'=>$request->section_name,
            'description'=>$request->description,
            'created_by'=>(Auth::user()->name)
        ]);
        session()->flash('Add', 'تم اضافة القسم بنجاح');
        return redirect('/sections');
        // $input = $request->all();
        // $b_exsits = sections::where('section_name', '=', $input['section_name'])->exists();

        // if($b_exsits) {
        //     session()->flash('Error', 'خطأ القسم موجود بالفعل');
        //     return redirect('/sections');
        // } else {
            // sections::create([
            //     'section_name'=>$request->section_name,
            //     'description'=>$request->description,
            //     'created_by'=>(Auth::user()->name)
            // ]);
            // session()->flash('Add', 'تم اضافة القسم بنجاح');
            // return redirect('/sections');
        // }





    }

    /**
     * Display the specified resource.
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request, [
            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'description' => 'required'
        ],[
            'section_name.required' => 'يرجي ادخال اسم القسم',
            'section_name.unique' => ' اسم القسم موجود بالفعل',
            'description.required' => 'يرجي ادخال البيانات',
        ]);

        $sections = sections::find($id);
        $sections->update([
            'section_name'=> $request->section_name,
            'description'=> $request->description,
        ]);

        session()->flash('edit' , 'تم تعديل القسم بنجاح');
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        sections::find($id)->delete();

        session()->flash('delete', 'تم حذف القسم بنجاح');
        return redirect('/sections');
    }
}
