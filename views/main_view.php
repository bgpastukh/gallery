<div class="container">
    <div class="row">

        <div class="starter-template">
            <h1 class="cover-heading">Beautiful gallery (no) </h1>
            <div class="col-md-6">
                <?php
                    while( $row = mysqli_fetch_assoc($data) ){
                        echo '<div class="image">';
                        echo '<div class="image-pic">';
                        echo '<img class="img-thumbnail user-image" src="' . '/second/public/uploads/' . $row['name'] .'">';
                        echo '</div>';
                        echo '<div class="image-info">';
                        echo '<div class="well date">' . $row['date'] . '</div>';
                        echo '<input type="text" class="well comment" value="'. $row['comment'] .'">';
                        echo '<div class="hidden">' . $row['id'] . '</div>';
                        echo '<button type="button" class="btn btn-sm btn-danger img-btn" onclick="window.location=\'/second/public/main/delete/'. $row['id'] .'\'" >Delete</button>';
                        echo '<button type="button" class="btn btn-sm btn-primary img-btn edit-btn">Edit</button>';
                        echo '</div>';
                        echo '</div>';
                    }
                    mysqli_free_result($data);
                    ?>
            </div>


            <div class="col-md-6">
                <form class="panel panel-default" action="#" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                    <input class="btn btn-lg btn-default choose rf" name="image" type="file" id="image" required/>
                    <br>
                    <label for="comment">Comment: </label> <input class="comment rf" type="text" name="comment" id="comment" required/>
                    <br>
                    <br>
                    <div class="btn btn-lg btn-default submit" >Send image</div>
                </form>

                <h2>Sort by:</h2>
                <button type="button" class="btn btn-default" onclick="window.location='/second/public/main/date/'">Date</button>
                <button type="button" class="btn btn-default" onclick="window.location='/second/public/main/size/'">Size</button>
                <button type="button" class="btn btn-default" onclick="window.location='/second/public/'">Don`t sort</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('.edit-btn').click(function (event) {
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
            alert('Comment was changed!');
        });
    });

    var files;
    var comment;
    // Function on change
    // Get files data

    $('input[type=file]').change(function () {
        files = this.files;
    });


    $('.submit').click(function (event) {
        event.stopPropagation();
        event.preventDefault();

//    Check empty fields and filesize
        var form = $('.panel');
        var maxsize = 1024 * 1024;

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
            alert('All fields required!');
            return;
        }

        var fileSize = files[0].size;

        if (fileSize > maxsize) {
            alert('Image is to big!');
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
//            $('html').html(data);
                location.reload();
        });
    });

</script>


