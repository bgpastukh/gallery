<div class="container">
    <div class="row">

        <div class="starter-template">
            <h1 class="cover-heading">Beautiful gallery (no) </h1>
            <div class="col-md-6">
                <?php
                    while( $row = mysqli_fetch_assoc($data) ){
                        echo '<div class="image">';
                        echo '<div class="image-pic">';
                        echo '<img class="img-thumbnail user-image" src="' . '/public/uploads/' . $row['name'] .'">';
                        echo '</div>';
                        echo '<div class="image-info">';
                        echo '<div class="well date">' . $row['date'] . '</div>';
                        echo '<div class="well comment">' . $row['comment'] . '</div>';
                        echo '<div class="hidden">' . $row['id'] . '</div>';
                        echo '<button type="button" class="btn btn-sm btn-danger img-btn" onclick="window.location=\'/public/main/delete/'. $row['id'] .'\'" >Delete</button>';
                        echo '<button type="button" class="btn btn-sm btn-primary img-btn" onclick="window.location=\'/public/main/edit/'. $row['id'] .'\'" id="edit-btn" >Edit</button>';
                        echo '</div>';
                        echo '</div>';
                    }
                    mysqli_free_result($data);
                    ?>
            </div>


            <div class="col-md-6">
                <form class="panel panel-default" action="#" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                    <input class="btn btn-lg btn-default choose" name="image" type="file" id="image" required/>
                    <br>
                    <label for="comment">Comment: </label> <input class="comment" type="text" name="comment" id="comment" required/>
                    <br>
                    <br>
                    <div class="btn btn-lg btn-default submit" >Send image</div>
                </form>

                <h2>Sort by:</h2>
                <button type="button" class="btn btn-default" onclick="window.location='/public/main/date/'">Date</button>
                <button type="button" class="btn btn-default" onclick="window.location='/public/main/size/'">Size</button>
                <button type="button" class="btn btn-default" onclick="window.location='/public/'">Don`t sort</button>
            </div>
        </div>
    </div>
</div>

<script>
//    document.getElementById('edit-btn').addEventListener('click', function(e) {
//        e.preventDefault();
//        if (confirm("Are you sure?")) {
//            document.location.href = '/compare/main/load';
//        }
//    });


var files;

// Вешаем функцию на событие
// Получим данные файлов и добавим их в переменную

$('input[type=file]').change(function(){
    files = this.files;
});

$('.submit').click(function( event ){
    event.stopPropagation(); // Остановка происходящего
    event.preventDefault();  // Полная остановка происходящего

    // Создадим данные формы и добавим в них данные файлов из files

    var data = new FormData();
    $.each( files, function( key, value ){
        data.append( key, value );
    });

    // Отправляем запрос

    $.ajax({
        url: '/public/main/upload/',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Не обрабатываем файлы (Don't process the files)
        contentType: false, // Так jQuery скажет серверу что это строковой запрос
        success: function( respond, textStatus, jqXHR ){

            // Если все ОК

            if( typeof respond.error === 'undefined' ){
                // Файлы успешно загружены, делаем что нибудь здесь

                // выведем пути к загруженным файлам в блок '.ajax-respond'

                var files_path = respond.files;
                var html = '';
                $.each( files_path, function( key, val ){ html += val +'<br>'; } )
                $('.ajax-respond').html( html );
            }
            else{
                console.log('ОШИБКИ ОТВЕТА сервера: ' + respond.error );
            }
        },
        error: function( jqXHR, textStatus, errorThrown ){
            console.log('ОШИБКИ AJAX запроса: ' + textStatus );
        }
    });

});

</script>
