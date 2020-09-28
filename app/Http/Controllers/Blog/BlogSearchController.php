<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Model\blog_category;
use Illuminate\Http\Request;
use App\Blog;

class BlogSearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'name' => 'nullable|string|regex:/^[a-zA-Z ]*$/',
            'category_id' => 'nullable|integer|exists:categories_for_blog,id'
        ]);


        $this->category_id = $request->category_id;
        $blogs = null;

        if($request->filled(['category_id' , 'name']))
        {
            $blogs = Blog::whereHas('categories', function (Builder $query) {
                $query->where('category_id', '=', $this->category_id);
                })
                ->where('title' ,'LIKE' , "%{$request->name}%")->paginate(6);
        }
        elseif($request->filled(['category_id']))
        {
            $blogs = Blog::whereHas('categories', function (Builder $query) {
                $query->where('category_id', '=',  $this->category_id);
            })->paginate(6);
        }
        elseif($request->filled(['name']))
        {
            $blogs = Blog::where('title' ,'LIKE' , "%{$request->name}%")
                ->paginate(6);
        }
        else{
            $blogs = Blog::with('user')->orderBy('id','desc')->paginate(6);
        }


        $categories = blog_category::all();
        $request->flash();
        return view('blog.index',compact('blogs','categories'));
    }
}
