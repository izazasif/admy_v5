<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){
        $title = "MyBdApps | Category List";
        $is_active = "category_list";

        $categories = Category::paginate(50);

        return view('portal.category.list', compact('title', 'is_active', 'categories'));
    }

    public function create(){
        $title = "MyBdApps | Create Category";
        $is_active = "category_create";

        return view('portal.category.create', compact('title', 'is_active'));
    }

    public function store(Request $request){
      $rules = [
          'title' => 'required',
          'status' => 'required',
      ];
      
      $messages = [
          'title.required' => 'Title field is required!',
          'status.required' => 'Status field is required!',
      ];
      
      $this->validate($request, $rules, $messages);

      $categoryData = new Category;
      $categoryData->title = $request->title;
      $categoryData->status = $request->status;
      $categoryData->save();

      $message = 'Category created successfully!';
      $log_write = storeActivityLog('Category','Category Create',json_encode($request->all()));
      return redirect()->route('category.list')->with('message',$message);
    }

    public function edit($id){
      $title = "MyBdApps | Edit Category";
      $is_active = "category_edit";

      $categoryDetail = Category::where('id', $id)->first();

      return view('portal.category.edit', compact('title', 'is_active', 'categoryDetail'));
    }

    public function update(Request $request){
      $rules = [
          'title' => 'required',
          'status' => 'required',
      ];
      
      $messages = [
          'title.required' => 'Title field is required!',
          'status.required' => 'Status field is required!',
      ];
      
      $this->validate($request, $rules, $messages);

      $category_id = $request->category_id;

      $categoryData = Category::where('id', $category_id)->first();
      $categoryData->title = $request->title;
      $categoryData->status = $request->status;
      $categoryData->save();

      $message = 'Category updated successfully!';
      $log_write = storeActivityLog('Category','Category Update',json_encode($request->all()));
      return redirect()->route('category.list')->with('message',$message);
    }

}
