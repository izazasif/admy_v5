<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\AudioClip;

class ClipController extends Controller
{
    public function index(){
        $title = "AdMy | Clip List";
        $is_active = "clip_list";

        $clips = AudioClip::paginate(50);

        return view('portal.clip.list', compact('title', 'is_active', 'clips'));
    }

    public function create(){
        $title = "AdMy | Create OBD Clip";
        $is_active = "clip_create";

        $categories = Category::where('status', 1)->get();

        return view('portal.clip.create', compact('title', 'is_active', 'categories'));
    }


    public function store(Request $request){
      $rules = [
        'category_id' => 'required',
        'title' => 'required',
        'clip' => 'required|mimes:mp3',
        'status' => 'required',
      ];

      $messages = [
        'category_id.required' => 'Category field is required!',
          'title.required' => 'Title field is required!',
          'clip.required' => 'Clip field is required!',
          'clip.mimes' => 'Clip must be a file of type: mp3!',
          'status.required' => 'Status field is required!',
      ];

      $this->validate($request, $rules, $messages);

    $clip_path = null;
    if($request->file('clip')){
        $file = $request->file('clip');
        $destinationPath = 'clips';
        $fileName = 'clip_'.strtotime("now");
        if($file->getClientOriginalExtension() == 'mp3'){
            $file->move($destinationPath, $fileName.'.mp3');
            $clip_path = $destinationPath.'/'.$fileName.'.mp3';
        }
    }

      $clipData = new AudioClip;
      $clipData->category_id = $request->category_id;
      $clipData->title = $request->title;
      $clipData->clip_path = $clip_path;
      $clipData->status = $request->status;
      $clipData->save();

      $message = 'OBD Clip created successfully!';
      $log_write = storeActivityLog('OBD','OBD Clip Create',json_encode($request->all()));
      return redirect()->route('clip.list')->with('message',$message);
    }

    public function edit($id){
      $title = "AdMy | Edit OBD Clip";
      $is_active = "clip_edit";

      $categories = Category::where('status', 1)->get();
      $clipDetail = AudioClip::where('id', $id)->first();

      return view('portal.clip.edit', compact('title', 'is_active', 'categories', 'clipDetail'));
    }

    public function update(Request $request){
        $rules = [
            'category_id' => 'required',
            'title' => 'required',
            'clip' => 'mimes:mp3',
            'status' => 'required',
          ];

          $messages = [
            'category_id.required' => 'Category field is required!',
              'title.required' => 'Title field is required!',
              'clip.mimes' => 'Clip must be a file of type: mp3!',
              'status.required' => 'Status field is required!',
          ];

      $this->validate($request, $rules, $messages);

      $clip_id = $request->clip_id;

      $clipData = AudioClip::where('id', $clip_id)->first();
      $clipData->category_id = $request->category_id;
      $clipData->title = $request->title;

      if($request->file('clip')){
        if(file_exists($clipData->clip_path)){
         unlink($clipData->clip_path);
        }

            $file = $request->file('clip');
            $destinationPath = 'clips';
            $fileName = 'clip_'.strtotime("now");
            if($file->getClientOriginalExtension() == 'mp3'){
                $file->move($destinationPath, $fileName.'.mp3');
                $clip_path = $destinationPath.'/'.$fileName.'.mp3';
            }
        $clipData->clip_path = $clip_path;
      }
      $clipData->status = $request->status;
      $clipData->save();

      $message = 'OBD Clip updated successfully!';
      $log_write = storeActivityLog('OBD','OBD Clip Update',json_encode($request->all()));
      return redirect()->route('clip.list')->with('message',$message);
    }

}
