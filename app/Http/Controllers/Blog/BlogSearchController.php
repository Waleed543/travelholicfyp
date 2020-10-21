<?php

namespace App\Http\Controllers\Blog;

use App\Enums\Status;
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

        $blogs = Blog::query();

        if($request->filled('name'))
        {
            $blogs->where('title' , 'LIKE' , "%{$request->name}%" );
        }
        if($request->filled('category_id'))
        {
            $blogs->whereHas('categories', function (Builder $query) {
                $query->where('category_id', '=', $this->category_id);
            });
        }

        $categories = blog_category::all();

        //Check if request is from admin dashboard
        if($request->routeIs('admin*'))
        {
            $blogs = $blogs->get();

            return view('admin.dashboard.blog.index',compact('blogs','categories'));
        }
        //Check if status is Active
        $blogs->where('status','=',Status::Active);

        $blogs = $blogs->paginate(6);

        $request->flash();
        return view('blog.index',compact('blogs','categories'));
    }
}
