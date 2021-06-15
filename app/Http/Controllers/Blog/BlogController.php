<?php

namespace App\Http\Controllers\Blog;

use App\Blog;
use App\Http\Requests\Blog\UpdateRequest;
use App\Tag;
use App\Model\tags_blog;
use App\Enums\Status;
use App\Http\Requests\Blog\StoreRequest;
use App\Model\blog_category;
use App\Http\Controllers\Controller;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     * use to allow only guest
     */
    public function __construct()
    {
        $this->middleware('auth' , ['except' => ['index','show','search']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::with('user')
            ->where('status','=',Status::Active)
            ->orderBy('id','desc')->paginate(6);
        $categories = blog_category::all();
        return view('blog.index',compact('blogs','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if ($request->hasFile('file')) {
            //get file name with extension
            $fileNameWithExt = $request->file('file')->getClientOriginalName();
            //get file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get extension
            $extension = $request->file('file')->getClientOriginalExtension();
            //file name
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            $path = $request->file('file')->storeAs( auth()->user()->username . '/blog', $fileNameToStore,'public');

        }

        $blog = new Blog;
        $blog->user_id = auth()->user()->id;
        $blog->title = Str::title($request->title);
        $blog->body = $request->body;
        //Slug Create
        $slug = Str::slug( $request->title, "-");
        $slug = $slug."-";
        $temp = Blog::where('slug','like',"{$slug}%")->orderBy('slug')->get()->last();
        if($temp != null)
        {
            $count = Str::afterLast($temp->slug, '-');
            $count +=1;
        }else{
            $count = 1;
        }
        $slug = $slug."".$count;

        $blog->slug = strtolower($slug);
        $blog->thumbnail = $fileNameToStore;
        $blog->status = Status::Requested;
        $blog->save();

        //create tags
        if($request->tags != null)
        {
            foreach ($request->tags as $name)
            {
                $tag = Tag::firstOrCreate([
                    'name' => $name,
                    'slug' => Str::slug($name)
                ]);

                $tags_blog = tags_blog::create([
                    'blog_id' => $blog->id,
                    'tag_id' => $tag->id
                ]);
            }
        }

        $blog->categories()->attach($request->categories);

        preg_match_all('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $request->body, $src);
        $srcArray = array_pop($src);

        $fileName = [];
        foreach($srcArray as $src ){
            $imgName=explode('/',$src);
            $fileName[]=end($imgName);
        }

        if($fileName != null)
        {
            $images = Image::where('imageable_type','App\Blog')
                ->where('user_id',auth()->user()->id)
                ->where('imageable_id',null)
                ->orwhere('imageable_id', $blog->id)->get();

            foreach ($images as $image)
            {
                if(in_array($image->name,$fileName))
                {
                    $image->imageable_id = $blog->id;
                    $image->save();
                }
                else{
                    Storage::delete('public/'.auth()->user()->username.'/blog/'.$image->name);
                    $image->delete();
                }
            }
        }


        return back()->with('popup_success','Blog Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($blog)
    {
        $blog = Blog::with(['user.profile','comments.user.profile','comments.replies.user.profile'])->where('slug', $blog)->first();
        
        abort_if($blog == null,'404');
        
        if(Auth::check())
        {
            if($blog->user_id == auth()->user()->id or Gate::allows('isAdmin')){
            return view('blog.show',compact('blog'));
        }
        }
        if($blog->status != Status::Active){
            abort('404');
        }
        

        return view('blog.show',compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $slug)
    {
        $blog = Blog::where('slug' , $slug)->first();

        abort_if($blog == null,'404');
        abort_unless($blog->user_id == auth()->user()->id or Gate::allows('isAdmin'),'401');

        if ($request->hasFile('file')) {
            //get file name with extension
            $fileNameWithExt = $request->file('file')->getClientOriginalName();
            //get file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get extension
            $extension = $request->file('file')->getClientOriginalExtension();
            //file name
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            $path = $request->file('file')->storeAs( $blog->user->username . '/blog', $fileNameToStore,'public');

            Storage::delete('public/'.$blog->user->username.'/blog/'.$blog->thumbnail);
            $blog->thumbnail = $fileNameToStore;

        }

        //Slug Create
        if($blog->title != $request->title)
        {
            $blog->title = Str::title($request->title);
            $slug = Str::slug( $request->title, "-");
            $count = Blog::where('slug','like',"%{$slug}%")->count();
            if($count > 0)
            {
                $slug = $slug."-".$count;
            }
            $blog->slug = strtolower($slug);
        }
        $blog->body = $request->body;
        $blog->status = Status::Requested;
        $blog->save();

        //delete changed tags
        $p_tags = $blog->tags;
        foreach ($p_tags as $p_tag)
        {
            if($request->tags == null or !in_array($p_tag->name,$request->tags))
            {
                $blog->tags()->detach($p_tag);
            }
        }
        //create new tags
        if($request->tags != null)
        {
            foreach ($request->tags as $name)
            {
                $tag = Tag::firstOrCreate([
                    'name' => $name,
                    'slug' => Str::slug($name)
                ]);

                $tags_tour = tags_blog::firstOrCreate([
                    'blog_id' => $blog->id,
                    'tag_id' => $tag->id
                ]);
            }
        }

        $blog->categories()->sync($request->categories);

        preg_match_all('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $request->body, $src);
        $srcArray = array_pop($src);

        $fileName = [];
        foreach($srcArray as $src ){
            $imgName=explode('/',$src);
            $fileName[]=end($imgName);
        }

        if($fileName != null)
        {
            $images = Image::where('imageable_type','App\Blog')
                ->where('user_id',auth()->user()->id)
                ->where('imageable_id',null)
                ->orwhere('imageable_id', $blog->id)->get();

            foreach ($images as $image)
            {
                if(in_array($image->name,$fileName))
                {
                    $image->imageable_id = $blog->id;
                    $image->save();
                }
                else{
                    Storage::delete('public/'.$blog->user->username.'/blog/'.$image->name);
                    $image->delete();
                }
            }
        }

        return back()->with('popup_success','Blog Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'image|max:1999'
        ]);
        if ($request->hasFile('file')) {
            //get file name with extension
            $fileNameWithExt = $request->file('file')->getClientOriginalName();
            //get file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get extension
            $extension = $request->file('file')->getClientOriginalExtension();
            //file name
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            $path = $request->file('file')->storeAs(  auth()->user()->username . '/blog', $fileNameToStore,'public');

            $image = Image::create([
                'user_id' => auth()->user()->id,
                'name' => $fileNameToStore,
                'type' =>$extension,
                'path' =>$path,
                'imageable_type' => 'App\Blog',
            ]);

        }
        else
            $fileNameToStore = null;

        if($fileNameToStore != null)
        {
            return response()->json(['location'=> '/storage/'.$path], 200);
        }
        else
            return response()->json(['location'=> 'File Not Uploaded'], 200);
    }
}
