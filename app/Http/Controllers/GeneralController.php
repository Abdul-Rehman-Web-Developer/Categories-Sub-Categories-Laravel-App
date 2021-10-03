<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function index(){
    	$categories_html = $this->renderAllCategories();
    	return view('home',[
    		'categories_html' => $categories_html
    	]);
    }
    public function add_category(Request $request){
    	
    	$messages = [
            'title.unique' => "A category with the following :attribute has already been added.",
      
        ];
		$validator=Validator::make($request->all(),[
            'title' => 'required|min:3|max:200|unique:categories,title'
        ],$messages);

        if ($validator->fails()) {
        	$error_html="<span style='color:red'>".$validator->messages()->getMessages()['title'][0]."</span>";
            return response()->json(["success"=> false, 'validation_error'=>$error_html ], 200);
        }

        $category = new Category;
        $category->title = $request->title;  
		$category->save();
        $categories_html = $this->renderAllCategories();
        return response()->json(["success"=> true,  'message'=>"<span style='color: #1ed35e'>Category successfully added.</span>", 'categories_html' => $categories_html], 200);


    }

    public function add_sub_category(Request $request){
    	
    	
		$validator=Validator::make($request->all(),[
            'title' => 'required|min:3|max:400'
        ]);

        if ($validator->fails()) {
        	$error_html="<span style='color:red'>".$validator->messages()->getMessages()['title'][0]."</span>";
            return response()->json(["success"=> false, 'validation_error'=>$error_html ], 200);
        }

        if(!Category::find($request->category_id)){
            return response()->json(["success"=> false, 'validation_error'=>"<span style='color:red'>An invalid Category ID submitted.</span>" ], 200);
        }

        if(Category::find($request->category_id)->subCategories()->where('sub_categories.title', $request->title)->exists()){
            return response()->json(["success"=> false, 'validation_error'=>"<span style='color:red'>A Sub Category with a given title has already been added to the chosen Category.</span>" ], 200);
		}

        $sub_category = new SubCategory;
        $sub_category->title = $request->title;  
        $sub_category->category_id = $request->category_id;  
		$sub_category->save();
        $categories_html = $this->renderAllCategories();

        return response()->json(["success"=> true,  'message'=>"<span style='color: #1ed35e'>Sub Category successfully added.</span>", 'categories_html' => $categories_html], 200);


    }

    public function delete_category(Request $request){

        if(!$category=Category::find($request->id)){
            return response()->json(["success"=> false, 'validation_error'=>"<span style='color:red'>An invalid Category ID submitted.</span>" ], 200);
        }

		$category->delete();
		
        $categories_html = $this->renderAllCategories();

        return response()->json(["success"=> true,  'message'=>"<span style='color: #1ed35e'>Category successfully deleted.</span>", 'categories_html' => $categories_html], 200);
  
    }


    public function delete_sub_category(Request $request){

        if(!$sub_category=SubCategory::find($request->id)){
            return response()->json(["success"=> false, 'validation_error'=>"<span style='color:red'>An invalid Sub Category ID submitted.</span>" ], 200);
        }

		$sub_category->delete();
		
        $categories_html = $this->renderAllCategories();

        return response()->json(["success"=> true,  'message'=>"<span style='color: #1ed35e'>Sub Category successfully deleted.</span>", 'categories_html' => $categories_html], 200);
  
    }

    private function renderAllCategories(){
     	$delete_category_route =route('delete_category');
     	$delete_sub_category_route =route('delete_sub_category');

    	$categories = Category::all();
        $html="<ul class='list-group  list-group-flush'>";
    	foreach ($categories as $category) {
    		$html.="
    			<li class='list-group-item category'>
    				<h5 class='category-heading'>
    				<span>".$category->title."</span>
    				<button class='btn btn-danger btn-sm delete-category-btn d-none' data-id='".$category->id."' data-url='".$delete_category_route."'>Delete</button>
    				<button class='btn btn-success btn-sm float-right add-category-btn d-none' data-category-id='".$category->id."' data-toggle='modal' data-target='#add-sub-category-modal'> + Add Sub Category </button>
    				</h5>
    				<ul class='list-group'>
    			";    		
                        
    		$sub_categories = Category::find($category->id)->subCategories;
    		foreach ($sub_categories as $sub_category) {
    			$html.="
    					<li class='list-group-item sub-category'>
    						".$sub_category->title."
    						<button class='btn btn-danger btn-sm delete-sub-category-btn d-none' data-id='".$sub_category->id."' data-url='".$delete_sub_category_route."'>Delete</button>
    					</li>";
    		}

    		$html.="</ul> </li>";
    	}
    	$html.="</ul>";

    	return $html;

    }
}
