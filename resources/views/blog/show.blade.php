@extends('layouts.app')
@section('nav','fixed-top')
@section('css-files')
    <link href="{{ asset('css/blog-single.css') }}" rel="stylesheet">
@endsection
@section('content')
    <script>
        window.onload = function blog_images() {
            var blogs = document.getElementById('blog_content');
            var blog = blogs.getElementsByTagName("img");
            var c = blog.length;
            var i;
            for(i=0;i<c;i++)
            {
                blog[i].style["height"] = "280px";
                blog[i].style["width"] = "1000px";
                blog[i].classList.add("img-fluid");
            }

        }
    </script>
    <div class="landing">
        <div class="home-wrap">
            <div class="home-inner" style="background-image: url('{{asset('img/blog.jpg')}}')">
            </div>
        </div>
    </div>
    <div class="caption text-center">
        <h1>Blogs</h1>
        <h3>Check Our Latest Blog</h3>
        <a class="btn btn-outline-light btn-lg" href="#course">Write Blog</a>
    </div>
    <!--- Start Courese Section -->
    <div class="jumbotron">
        <div class="narrow text-center">
            <div class="col-12">
                <h1>All Blogs Related To Tourism</h1>
                <p class="lead">You will find all the tips and articles which will help you in tourism.</p>
                <a class="btn btn-secondary btn-md" href="#" target="_blank">Write Your Own Blog</a>
            </div>
        </div><!--- End Narrow Section -->
    </div>
    <!--- Start Courese Section -->
    <!--- Start Blog Section -->
    <div class="container-fluid">
        <div class="container">
            <div class="row welcome text-center">
                <div class="col-12">
                    <h1 class="display-4">Blogs</h1>
                </div>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="page-wrapper">
                    <div class="blog-title-area">
                        <div class="card blog-body" style="margin-left: 0">
                            <h3 class="search card-header white-text text-center py-4">{{$blog->title}}</h3>
                            <div class="card-body">
                                <div class="single-post-media">
                                    <img class="img-fluid" style="hieght :10x; width: 1000px;" src="{{asset('storage/'.$blog->user->username.'/blog/'.$blog->thumbnail)}}">
                                </div>
                                <br>
                                <div class="blog-content text-justify text-dark" style="max-width: 10000px" id="blog_content">
                                    {!!$blog->body!!}
                                </div><!-- end content -->
                            </div>
                            <div style="background-color: ghostwhite" class="card-footer">
                                <div style="" class="card-text">
                                    <div class="row">
                                        <div class="col-2 col-lg-1">
                                            <a href=""><i class="far fa-comment fa-3x fa-flip-horizontal"></i></a>
                                        </div>
                                        <div class="col-10 col-lg-10 mt-2">
                                            <h4>Comments</h4>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <ul class="p-0">
                                    {{-- Main comment body--}}
                                    @if(count($blog->comments) > 0)
                                        @foreach($blog->comments as $comment)
                                            @php
                                                $now = \Illuminate\Support\Carbon::now();
                                                $created = new \Illuminate\Support\Carbon($comment->created_at);
                                                $difference = ($created->diff($now)->days);

                                                $span = 'day ago';
                                                if($difference == 0){
                                                    $difference = ($created->diff($now)->h);
                                                    $span = 'hour ago';
                                                }
                                                if($difference == 0){
                                                    $difference = ($created->diff($now)->i);
                                                    $span = 'minutes ago';
                                                }
                                                if($difference == 0){
                                                        $difference = null;
                                                        $span = 'now';
                                                    }

                                            @endphp
                                            <li id="comment-{{$comment->id}}">
                                                <div class="row comment-box">
                                                    <div class="col-2 col-sm-4 col-lg-2 user-img text-center">
                                                        <img src="{{asset('storage/'.$comment->user->username.'/profile_image/'.$comment->user->profile->image)}}" class="main-cmt-img">
                                                    </div>
                                                    <div class="col-10 col-sm-8 col-lg-10 user-comment bg-light rounded">
                                                        <div class="row">
                                                            <div class="col-lg-12 border-bottom pr-0 comment-body">
                                                                <p class="w-100 p-2 m-0">{{$comment->body}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row user-comment-desc">
                                                            <div class="time">
                                                                <p class="w-100 p-2 m-0"><span class="float-right"><i class="far fa-clock"></i> {{$difference}} {{$span}}</span></p>
                                                            </div>
                                                            <div class="ml-auto">
                                                                <a id="reply-link-{{$comment->id}}" href="#reply-section-{{$comment->id}}" data-toggle="collapse" class="m-0 mr-2"><i class="fas fa-reply" aria-hidden="true"></i></a>
                                                                <button type="submit" form="delete-comment-{{$comment->id}}" style="padding: 0" class="m-0 mr-2 btn btn-link btn-sm">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                                <form class="delete_comment" id="delete-comment-{{$comment->id}}">
                                                                    @csrf
                                                                    <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                                                </form>
                                                            </div>
                                                        </div>
                                                        {{-- Reply Section --}}
                                                        @auth
                                                        <div id="reply-section-{{$comment->id}}" class="row collapse reply-section">
                                                            <div class="col-lg-1 col-1">
                                                                <div class="reply-img">
                                                                    <img src="{{asset('storage/'.auth()->user()->username.'/profile_image/'.auth()->user()->profile->image)}}" class="sub-cmt-img">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-10 col-9">
                                                                <form class="new_comment" id="comment-submit-{{$comment->id}}" method="POST">
                                                                    @csrf
                                                                    <textarea onkeyup="textAreaAdjust(this)" style="overflow:hidden" rows="1" type="text" name="body" class="form-control" placeholder="write reply ..."></textarea>
                                                                    <input type="hidden" name="blog_id" value="{{$blog->id}}">
                                                                    <input type="hidden" name="parent_id" value="{{$comment->id}}">
                                                                </form>
                                                            </div>
                                                            <div class="col-1 col-lg-1 send-icon">
                                                                <a type="button" onclick="event.preventDefault();commentFormSubmit({{$comment->id}});" class="btn btn-link">
                                                                    <i class="fa fa-paper-plane"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        @endauth
                                                        {{-- Reply Section End --}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-11 ml-auto mr-0 pr-0">
                                                        <ul class="p-0">
                                                            <li>
                                                                {{-- Start of reply comment--}}
                                                                @if(count($comment->replies) > 0)
                                                                    @foreach($comment->replies as $reply)
                                                                        @php
                                                                            $now = \Illuminate\Support\Carbon::now();
                                                                            $created = new \Illuminate\Support\Carbon($reply->created_at);
                                                                            $difference = ($created->diff($now)->days);

                                                                            $span = 'day ago';
                                                                            if($difference == 0){
                                                                                $difference = ($created->diff($now)->h);
                                                                                $span = 'hour ago';
                                                                            }
                                                                            if($difference == 0){
                                                                                $difference = ($created->diff($now)->i);
                                                                                $span = 'minutes ago';
                                                                            }
                                                                            if($difference == 0){
                                                                                    $difference = null;
                                                                                    $span = 'now';
                                                                                }
                                                                        @endphp
                                                                        <div id="comment-{{$reply->id}}">
                                                                        <div class="row comment-box reply-box mt-2">
                                                                            <div class="col-1 col-sm-1 col-lg-1 user-img text-center ml-lg-5">
                                                                                <img src="{{asset('storage/'.$reply->user->username.'/profile_image/'.$reply->user->profile->image)}}" class="sub-cmt-img">
                                                                            </div>
                                                                            <div class="col-9 col-sm-8 col-lg-10 user-comment bg-light rounded ml-auto">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 border-bottom pr-0 comment-body">
                                                                                        <p class="w-100 p-2 m-0">{{$reply->body}}</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row user-comment-desc">
                                                                                    <div class="time">
                                                                                        <p class="w-100 p-2 m-0"><span class="float-right"><i class="far fa-clock"></i> {{$difference}} {{$span}}</span></p>
                                                                                    </div>
                                                                                    <div class="ml-auto">
                                                                                        <button type="submit" form="delete-comment-{{$reply->id}}" style="padding: 0" class="m-0 mr-2 btn btn-link btn-sm">
                                                                                            <i class="fas fa-trash-alt"></i>
                                                                                        </button>
                                                                                        <form class="delete_comment" id="delete-comment-{{$reply->id}}">
                                                                                            @csrf
                                                                                            <input type="hidden" name="comment_id" value="{{$reply->id}}">
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                        </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                                <span id="child-comment-{{$comment->id}}"></span>
                                                                {{-- End of reply comment--}}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                            <span id="main-comment"></span>
                                            <hr>
                                    @else
                                        <span id="main-comment-first"></span>
                                        <h5 id="no-comment" class="text-primary">
                                            Be the first to comment
                                        </h5>
                                        <hr>
                                    @endif
                                    {{-- End of main comment--}}
                                    @auth
                                        <h2> Post Your Comment</h2>
                                        <div class="row your-comment">
                                            <div class="col-lg-1 col-1 p-0 mr-2">
                                                <div class="user-img">
                                                    <img src="{{asset('storage/'.auth()->user()->username.'/profile_image/'.auth()->user()->profile->image)}}" class="main-cmt-img">
                                                </div>
                                            </div>
                                            <div class="col-lg-9 col-9 p-0 mt-lg-2">
                                                <form class="new_comment" id="new_comment" method="POST">
                                                    @csrf
                                                    <textarea onkeyup="textAreaAdjust(this)" style="overflow:hidden" rows="1" type="text" name="body" class="form-control" placeholder="write comment ..."></textarea>
                                                    <input type="hidden" name="blog_id" value="{{$blog->id}}">
                                                </form>
                                            </div>
                                            <div class="col-lg-1 col-1 send-icon">
                                                <button type="submit" form="new_comment" class="btn btn-link">
                                                    <i class="fa fa-paper-plane fa-2x m-0 mt-1" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <br>
                                        <h3>Login to join the conversation</h3>
                                    @endauth
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card writer">
                    <!--Card content-->
                    <img src="{{asset('storage/'.$blog->user->username.'/profile_image/'.$blog->user->profile->image)}}" alt="John" style="width:100%">
                    <br>
                    <h1>{{$blog->user->name}}</h1>
                    <p class="title">CEO & Founder, Example</p>
                    <p>Harvard University</p>
{{--                    <a href="#"><i class="fa fa-dribbble"></i></a>--}}
{{--                    <a href="#"><i class="fa fa-twitter"></i></a>--}}
{{--                    <a href="#"><i class="fa fa-linkedin"></i></a>--}}
{{--                    <a href="#"><i class="fa fa-facebook"></i></a>--}}
                </div>
            </div>
        </div>
    </div>
    <!--- End Blog Section -->
    @auth
    <script>
        var src = "{{asset('storage/'.auth()->user()->username.'/profile_image/'.auth()->user()->profile->image)}}";
        var csrf = "{{csrf_token()}}";
    </script>
    @endauth
    <script src="{{asset('js/blog-single.js')}}" type="text/javascript"></script>

@endsection
