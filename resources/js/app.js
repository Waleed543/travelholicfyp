require('./bootstrap');

//TinyMCE
require("../../node_modules/tinymce/icons/default/icons.js");
require('tinymce/themes/silver');
require('tinymce/plugins/image');
require('tinymce/plugins/code');

import tinymce from 'tinymce';
tinymce.init({
    selector: 'textarea#inputContent',
    plugins: 'image code',
    height: 400,
    skin: false,
    content_css: false,
    relative_urls: false,
    images_upload_handler: function (blobInfo, success, failure) {
        let formData = new FormData();
        formData.append('file', blobInfo.blob());
        axios.post('/blog/upload', formData)
            .then(function(res){
                success(res.data.location);
            });
    }
});
