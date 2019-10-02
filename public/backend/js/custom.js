$('.select').chosen();

/* tinymce without photo */
tinymce.init({
    selector: '.tinymceSimple',
    menubar: false,
});

/* Tinymce With photo */
tinymce.init({
  selector: '.tinymce',
  menubar: false,
  theme: 'modern',
  plugins: 'image code link lists textcolor imagetools colorpicker ',
browser_spellcheck: true,
  toolbar1: 'formatselect | bold italic strikethrough | link image | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
  // enable title field in the Image dialog
  image_title: true, 
  // enable automatic uploads of images represented by blob or data URIs
  automatic_uploads: true,
  // URL of our upload handler (for more details check: https://www.tinymce.com/docs/configure/file-image-upload/#images_upload_url)
  // images_upload_url: 'postAcceptor.php',
  // here we add custom filepicker only to Image dialog
  file_picker_types: 'image', 
  // and here's our custom image picker
  file_picker_callback: function(cb, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
    
    // Note: In modern browsers input[type="file"] is functional without 
    // even adding it to the DOM, but that might not be the case in some older
    // or quirky browsers like IE, so you might want to add it to the DOM
    // just in case, and visually hide it. And do not forget do remove it
    // once you do not need it anymore.

    input.onchange = function() {
      var file = this.files[0];
      
      var reader = new FileReader();
      reader.onload = function () {
        // Note: Now we need to register the blob in TinyMCEs image blob
        // registry. In the next release this part hopefully won't be
        // necessary, as we are looking to handle it internally.
        var id = 'blobid' + (new Date()).getTime();
        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
        var base64 = reader.result.split(',')[1];
        var blobInfo = blobCache.create(id, file, base64);
        blobCache.add(blobInfo);

        // call the callback and populate the Title field with the file name
        cb(blobInfo.blobUri(), { title: file.name });
      };
      reader.readAsDataURL(file);
    };
    
    input.click();
  }
});

/*==== For Photo show in frontend*/
$(document).ready(function(){
    $("#file").change(function(){
        readURL(this);
    });

});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#image_load').attr('src', e.target.result);
            $('.post_upload').height('auto');
        }

        reader.readAsDataURL(input.files[0]);
    }
}
function loadPhoto(input,id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#'+id).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
/*============*/
$(function(){
    $(':input[type=number]').on('mousewheel',function(e){ $(this).blur(); });
});
$('form input').on('keypress', function(e) {
    return e.which !== 13;
});




/**
 * For delete any item.
 * @param setting
 * @param event
 */
$.fn.itemDelete = function (setting, event) {
    setting = $.extend({
        warningText: 'Something going wrong !',
        successText: 'Successfully deleted !'
    }, setting);

    $(this).on('click', function (e) {
        var that = $(this),
            url = that.attr('href');
        e.preventDefault();

        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
        })
            .then((isConfirm) => {
                if (isConfirm.value){
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {_token: $('meta[name=csrf-token]').attr('content'), _method: 'DELETE'},
                        success: function (response) {
                            if (response.check){
                                that.parents('tr').remove();
                                swal({
                                    type: 'success',
                                    text: response.message !== undefined ? response.message : setting.successText,
                                    timer: 1000,
                                });
                            } else {
                                swal({
                                    type: 'warning',
                                    text: response.message !== undefined ? response.message : setting.warningText,
                                    timer: 3000
                                })
                            }
                        },
                        error: function (error) {
                            console.log(error)
                        }
                    });
                } else {
                    // If not confirm.
                }
            });
    });
};

/**
 * Add new item on search / autocomplete
 * For example : paid to supplier, receive from customer, expense sector.
 * @param setting
 */
$.fn.addNewItem = function (setting, event) {
    var settings = $.extend({
        checkOnConsole: false,
        modalId: ''
    }, setting);

    $(this).on('submit', function (e) {
        var that = $(this),
            data = that.serializeArray(),
            url = that.attr('action');
        if (setting.checkOnConsole){
            console.log('before submit', data)
        }
        $.ajax({
            url: url,
            data: data,
            type: 'post',
            success: function (data) {
                if (setting.checkOnConsole){
                    console.log('in success', data)
                }
                if (data.check){
                    // that.get(0).reset();
                    swal({
                        title: 'Success !',
                        timer: 500
                    });
                    $('#'+settings.modalId).modal('hide');
                }
            },
            error: function (error) {
                var errors = error.responseJSON.errors;

                if (errors != undefined){
                    that.find('input').each(function (index, item) {
                        if (errors.hasOwnProperty(item.name)){
                            $(item).parent().find('p').remove();
                            $(item).parent().addClass('has-error');
                            $(item).parent().append(`<p class="help-block">${errors[item.name][0]}</p>`);
                        } else if (error.hasOwnProperty(item.name.replace('[]', '.0'))){
                            $(item).parent().find('p').remove();
                            $(item).parent().addClass('has-error');
                            $(item).parent().append(`<p class="help-block">${errors[item.name.replace('[]', '.0')]}</p>`);
                        }
                    });

                    that.find('select').each(function (index, item) {
                        if (errors.hasOwnProperty(item.name)){
                            $(item).parent().append(`<p class="help-block">${errors[item.name][0]}</p>`);
                        }
                    })
                }
            }
        });
        return false;
    })
};

$('.deletable').itemDelete();