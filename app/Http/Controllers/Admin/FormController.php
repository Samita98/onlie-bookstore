<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Form;


class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.form.list', [
        'title'=>'Forms List',
        'forms'=>Form::orderBy('id', 'desc')->paginate(10)
        ]);
    }
    public function edit($id)
    {
        return view('admin.form.form', [
        'title'=>'Edit Form',
        'form'=>Form::find($id)
        ]);
    }
    public function update(Request $request, $id)
    {
        $form = Form::findOrFail($id);
        $form->email = $request->email;
        $form->setup  = @serialize($request->setup);
        $form->success_msg = $request->success_msg;
        $form->save();

        return redirect('/admin/form/'.$form->id.'/edit');
    }
    public function show($id)
    {
         return view('admin.form.entries', [
        'title'=>'Entries',
        'entries'=>\App\Model\Entries::where('form_id', $id)->orderBy('id', 'desc')->paginate(10),
        'form'=>Form::find($id)
        ]);
    }
    public function entries($id)
    {
         return view('admin.form.view', [
        'title'=>'Entries',
        'entry'=>\App\Model\Entries::find($id),
        'entries'=>\App\Model\Entryfield::where('entry_id', $id)->get()
        ]);
    }

}
