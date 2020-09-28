function commentFormSubmit(data)
{
    var form = document.getElementById("comment-submit-"+data);

    $.ajax({
        url:"/blog/comment/create",
        method:"POST",
        data:new FormData(form),
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success:function(data)
        {
            show_message(data);
        }
    });

    document.getElementById("reply-link-"+data).click();
}
$(document).ready(function(){
    $(document).on('submit','.delete_comment',function(event){
        event.preventDefault();
        $.ajax({
            url:"/blog/comment/delete",
            method:"POST",
            data:new FormData(this),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data)
            {
                show_message_delete(data);
            }
        })
    });
    $(document).on('submit','.new_comment',function(event){
        event.preventDefault();
        $.ajax({
            url:"/blog/comment/create",
            method:"POST",
            data:new FormData(this),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data)
            {
                show_message(data);
            }
        })
    });
});

function show_message_delete(data) {

    document.getElementById("comment-"+data.comment_id).remove();

    alert(data.message);
}

function show_message(data) {
    var x = data.error;
    if(x != 1)
    {
        var message = data.message;
        if(data.isChild)
        {
            const div = document.createElement('div');
            div.setAttribute('id',"comment-"+data.comment_id);
            div.innerHTML =`
        <div class="row comment-box reply-box mt-2">
            <div class="col-1 col-sm-1 col-lg-1 user-img text-center ml-lg-5">
            <img src="${src}" class="sub-cmt-img">
            </div>
            <div class="col-9 col-sm-8 col-lg-10 user-comment bg-light rounded ml-auto">
            <div class="row">
            <div class="col-lg-12 border-bottom pr-0 comment-body">
            <p class="w-100 p-2 m-0">${data.body}</p>
        </div>
        </div>
        <div class="row user-comment-desc">
            <div class="time">
            <p class="w-100 p-2 m-0"><span class="float-right"><i class="far fa-clock"></i> now</span></p>
        </div>
        <div class="ml-auto">
            <button type="submit" form="delete-comment-${data.comment_id}" style="padding: 0" class="m-0 mr-2 btn btn-link btn-sm">
            <i class="fas fa-trash-alt"></i>
            </button>
            <form class="delete_comment" id="delete-comment-${data.comment_id}">
            <input type="hidden" name="_token" value=${csrf}>
            <input type="hidden" name="comment_id" value="${data.comment_id}">
            </form>
            </div>
            </div>
            </div>
                    

                        `;
            document.getElementById("child-comment-"+data.parent_id).appendChild(div);
            alert('Comment has been posted');

        }else{
            const div = document.createElement("li");
            div.setAttribute('id',"comment-"+data.parent_id);
            div.innerHTML =`
                                                <div class="row comment-box">
                                                    <div class="col-2 col-sm-4 col-lg-2 user-img text-center">
                                                        <img src="${src}" class="main-cmt-img">
                                                    </div>
                                                    <div class="col-10 col-sm-8 col-lg-10 user-comment bg-light rounded">
                                                        <div class="row">
                                                            <div class="col-lg-12 border-bottom pr-0 comment-body">
                                                                <p class="w-100 p-2 m-0">${data.body}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row user-comment-desc">
                                                            <div class="time">
                                                                <p class="w-100 p-2 m-0"><span class="float-right"><i class="far fa-clock"></i> now</span></p>
                                                            </div>
                                                            <div class="ml-auto">
                                                                <a id="reply-link-${data.parent_id}" href="#reply-section-${data.parent_id}" data-toggle="collapse" class="m-0 mr-2"><i class="fas fa-reply" aria-hidden="true"></i></a>
                                                                <button type="submit" form="delete-comment-${data.parent_id}" style="padding: 0" class="m-0 mr-2 btn btn-link btn-sm">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                                <form class="delete_comment" id="delete-comment-${data.parent_id}">
                                                                    <input type="hidden" name="_token" value=${csrf}>
                                                                    <input type="hidden" name="comment_id" value="${data.parent_id}">
                                                                </form>
                                                            </div>
                                                        </div>
                                                        
                                                        <div id="reply-section-${data.parent_id}" class="row collapse reply-section">
                                                            <div class="col-lg-1 col-1">
                                                                <div class="reply-img">
                                                                    <img src="${src}" class="sub-cmt-img">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-10 col-9">
                                                                <form class="new_comment" id="comment-submit-${data.parent_id}" method="POST">
                                                                    <input type="hidden" name="_token" value=${csrf}>
                                                                    <textarea onkeyup="textAreaAdjust(this)" style="overflow:hidden" rows="1" type="text" name="body" class="form-control" placeholder="write reply ..."></textarea>
                                                                    <input type="hidden" name="blog_id" value="${data.blog_id}">
                                                                    <input type="hidden" name="parent_id" value="${data.parent_id}">
                                                                </form>
                                                            </div>
                                                            <div class="col-1 col-lg-1 send-icon">
                                                                <a type="button" onclick="event.preventDefault();commentFormSubmit(${data.parent_id});" class="btn btn-link">
                                                                    <i class="fa fa-paper-plane"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                                 <div class="row">
                                                    <div class="col-lg-11 ml-auto mr-0 pr-0">
                                                        <ul class="p-0">
                                                            <li>         
                                                             <span id="child-comment-${data.parent_id}"></span>
                                        
                                                            </li>
                                                            </ul>
                                                     </div>
                                                  </div>                                     
`;

            var span = document.getElementById('main-comment');//.appendChild(div);
            if(span != null)
            {
                span.appendChild(div);
            } else{
                var element = document.getElementById('no-comment');
                element.parentNode.removeChild(element);
                document.getElementById('main-comment-first').appendChild(div);
            }
            alert('Comment Posted');
        }

    } else{
        alert('Comment not posted');
    }

}

function textAreaAdjust(o) {
    o.style.height = "1px";
    o.style.height = (o.scrollHeight)+"px";
}
