<?php

namespace App\Http\Controllers\User;

use App\Blog;
use App\Http\Controllers\Controller;
use App\Model\blog_category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Enums\Status;

class BlogController extends Controller
{
    public function index()
    {
        $categories = blog_category::all();
        $blogs = auth()->user()->blogs()->paginate(15);
        return view('user.dashboard.blog.index',compact('blogs','categories'));
    }

    public function create()
    {
        $categories = DB::table('categories_for_blog')->get();
        return view('user.dashboard.blog.create',compact('categories'));
    }

    public function edit($slug)
    {
        $blog = Blog::where('slug' , $slug)->first();
        $categories = DB::table('categories_for_blog')->get();
        abort_if($blog == null,'404','Blog not found');
        abort_if($blog->user_id != auth()->user()->id,'401');

        return view('user.dashboard.blog.edit',compact('blog','categories'));

    }
    
    public function status($slug)
        {
                $blog = Blog::where('slug' , $slug)->first();

                abort_if($blog == null,'404','Blog not found');
                abort_if($blog->user_id != auth()->user()->id,'401');

                $blog->status= Status::InActive;

                $blog->save();

                return back()->with('popup_success','Success');

        }
        public function statusRequested($slug)
        {
                $blog = Blog::where('slug' , $slug)->first();

                abort_if($blog == null,'404','Tour not found');
                abort_if($blog->user_id != auth()->user()->id,'401');

                $blog->status= Status::Requested;

                $blog->save();

                return back()->with('popup_success','Success');

        }

    public function destroy($slug)
    {
        $blog = Blog::where('slug' , $slug)->first();
        abort_if($blog == null,'404','Blog not found');
        abort_if($blog->user_id != auth()->user()->id,'401');

        //Deleting Blog Categories
        $blog->categories()->detach();

        //Deleting Blog Images
        $images = $blog->images;
        if($images != null)
        {
            foreach ($images as $image)
            {
                $image->delete();
            }
        }

        //Deleting Blog Comments
        $comments = $blog->allComments;
        if($comments != null)
        {
            foreach ($comments as $comment)
            {
                $comment->delete();
            }
        }

        //Deleting Blog Thumbnail
        Storage::delete('public/'.auth()->user()->username.'/blog/'.$blog->thumbnail);

        //Deleting Blog
        $blog->delete();

        return back()->with('popup_success','Blog deleted successfully');

    }



}
