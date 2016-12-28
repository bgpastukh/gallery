<div class="container">
    <div class="row">
        <div class="starter-template">
            <h1 class="cover-heading">Beautiful gallery (no) </h1>
            <div class="col-md-6 gallery">
                <?= $data ?>
            </div>

            <div class="col-md-6">
                <form class="panel panel-default" action="#" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                    <input class="btn btn-lg btn-default choose rf" name="image" type="file" id="image"/>
                    <br>
                    <label for="comment">Comment: </label> <input class="comment rf" type="text" name="comment" id="comment" required/>
                    <br>
                    <br>
                    <div class="btn btn-lg btn-default submit" >Send image</div>
                </form>

                <h2>Sort by:</h2>
                <button type="button" class="btn btn-default sort-date">Date</button>
                <button type="button" class="btn btn-default sort-size"">Size</button>
            </div>
        </div>
    </div>
</div>

