//    Delete image
$('body').on('click', '.delete-btn', function () {
    event.stopPropagation();
    event.preventDefault();
//        Get id
    var info = $(this).parent();
    var id = info.find('.hidden').text();
    var src = info.parent().find('.user-image').attr('src');

    $.post(
        '/second/public/main/delete/',
        {
            'id': id,
            'src': src
        }
    ).done(function () {
        var blockToDel = info.parent();
        blockToDel.detach();
        $('.massage').addClass('bg-success');
        $('.massage').text('Deleted!');
    });
});

//    Edit comment
$('body').on('click', '.edit-btn', function () {
    event.stopPropagation();
    event.preventDefault();
//        Get id and comment
    var info = $(this).parent();
    var id = info.find('.hidden').text();
    var comment = info.find('.comment').val();

//        Sending
    $.post(
        '/second/public/main/edit/',
        {
            'id': id,
            'comment': comment
        }
    ).done(function () {
        $('.massage').addClass('bg-success');
        $('.massage').text('Comment was changed!');
    });
});

var files;
var comment;

// Get files data
$('input[type=file]').change(function () {
    files = this.files;
});

//    Upload new image
$('.submit').click(function (event) {
    event.stopPropagation();
    event.preventDefault();

//    Check empty fields, format and file size
    var form = $('.panel');
    var maxsize = 1024 * 1024;
    var allowedFormats = /\.(png|jpe?g)$/i;

    form.find('.rf').each(function () {
        if ($(this).val()) {
            $(this).removeClass('empty_field');
        } else {
            $(this).addClass('empty_field');
        }
    });

    form.find('.empty_field').css({'border-color': '#d8512d'});
    // Через полсекунды удаляем подсветку
    setTimeout(function () {
        form.find('.empty_field').removeAttr('style');
    }, 800);


    var emptyFields = $('.empty_field');
    if (emptyFields[0]) {
        $('.massage').addClass('bg-danger');
        $('.massage').text('All fields required!');
        return;
    }

    var fileSize = files[0].size;

    if (fileSize > maxsize) {
        $('.massage').addClass('bg-danger');
        $('.massage').text('Image is to big!');
        return;
    }

    var input = document.getElementById('image');
    var status = allowedFormats.test(input.value);
    if (!status){
        $('.massage').addClass('bg-danger');
        $('.massage').text('Not allowed format!');
        return;
    }

    // Make data to send
    var data = new FormData();
    $.each(files, function (key, value) {
        data.append(key, value);
    });

    comment = $('#comment').val();
    data.append('comment', comment);

    // Sending
    $.post({
        url: '/second/public/main/upload/',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'html',
        processData: false, // Don't process the files
        contentType: false
    }).done(function (data) {
        $('.gallery').append(data);
        $('.massage').addClass('bg-success');
        $('.massage').text('Image was uploaded!');
    });
});

//  Sort by date
$('.sort-date').click(function () {
   $.get('/second/public/main/sort_date/').done(function (data) {
       $('.gallery').html(data);
   })
});

$('.sort-size').click(function () {
   $.get('/second/public/main/sort_size/').done(function (data) {
       $('.gallery').html(data);
   })
});



