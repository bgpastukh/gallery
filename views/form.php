    <div class="image">
        <div class="image-pic">
            <img class="img-thumbnail user-image" src="/second/public/uploads/<?= $row['name'] ?>">
        </div>
        <div class="image-info">
            <div class="well date"><?= $row['date'] ?></div>
            <input type="text" class="well comment" value="<?= $row['comment'] ?>">
            <div class="hidden"><?= $row['id'] ?></div>
            <button type="button" class="btn btn-sm btn-danger img-btn delete-btn">Delete</button>
            <button type="button" class="btn btn-sm btn-primary img-btn edit-btn">Edit</button>
        </div>
    </div>
