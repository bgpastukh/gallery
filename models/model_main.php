<?php

class Model_Main extends Model
{
    public $link;

    public function connectDB()
    {
        // DB connection
        $link = mysqli_connect("localhost", "pastukh", "3stUdiowoRks3", "pastukh");

        if (!$link) {
            throw new Exception('Can not connect to DB');
        }

        $this->link = $link;
    }

    public function showGallery()
    {
        $query = "SELECT * FROM `gallery`";
        $result = $this->formTable($query);
        return $result;
    }

    public function upload()
    {
        $link = $this->link;
        $uploadDir = '/var/www.pastukh/gallery.local/www/second/public/uploads/';
        $uploadFile = $uploadDir . basename($_FILES[0]['name']);
        $comment = $_POST['comment'];
        $name = $_FILES[0]['name'];
        $size = $_FILES[0]['size'];

        $date = date("Y-m-d H:i:s");

        if ($_FILES[0]['size'] > 1000000) {
            throw new Exception('Error! Image is to big!');
        }

        preg_match('!\.(png|jpe?g)$!i', $name, $matches);

        if (!$matches) {
            throw new Exception('Error! Allowed formats: jpg, jpeg, png');
        }

        if (!move_uploaded_file($_FILES[0]['tmp_name'], $uploadFile)) {
            die('File was not uploaded!');
        }

        $query = "INSERT INTO `gallery`(`name`, `date`, `comment`, `size`) VALUES ('$name', '$date', '$comment', '$size')";

        if (!mysqli_query($link, $query)) {
            throw new Exception('Error! SQL-query was not performed');
        }

        $id = mysqli_insert_id($link);

        $data = <<<EOD
            <div class="image">
                <div class="image-pic">
                    <img class="img-thumbnail user-image" src="/second/public/uploads/$name">
                </div>
                <div class="image-info">
                    <div class="well date">$date</div>
                    <input type="text" class="well comment" value="$comment">
                    <div class="hidden">$id</div>
                    <button type="button" class="btn btn-sm btn-danger img-btn delete-btn">Delete</button>
                    <button type="button" class="btn btn-sm btn-primary img-btn edit-btn">Edit</button>
                </div>
            </div>
EOD;

        return $data;
    }

    public function sortByDate()
    {
        $query = "SELECT * FROM `gallery` ORDER BY date;";
        $result = $this->formTable($query);
        return $result;
    }

    public function sortBySize()
    {
        $query = "SELECT * FROM `gallery` ORDER BY size;";
        $result = $this->formTable($query);
        return $result;
    }

    public function delete()
    {
        $link = $this->link;
        $id = $_POST['id'];
        $query = "DELETE FROM `gallery` WHERE `id` = {$id}";
        mysqli_query($link, $query);
    }

    public function edit()
    {
        $link = $this->link;
        $id = $_POST['id'];
        $comment = htmlspecialchars($_POST['comment']);
        $query = "UPDATE `gallery` SET comment='$comment' WHERE `id` = {$id}";
        mysqli_query($link, $query);
    }

    private function formTable($query)
    {
        $link = $this->link;
        $data = mysqli_query($link, $query);
        $str = "";
        while ($row = mysqli_fetch_assoc($data)) {
            $str .= '<div class="image">';
            $str .= '<div class="image-pic">';
            $str .= '<img class="img-thumbnail user-image" src="' . '/second/public/uploads/' . $row['name'] . '">';
            $str .= '</div>';
            $str .= '<div class="image-info">';
            $str .= '<div class="well date">' . $row['date'] . '</div>';
            $str .= '<input type="text" class="well comment" value="' . $row['comment'] . '">';
            $str .= '<div class="hidden">' . $row['id'] . '</div>';
            $str .= '<button type="button" class="btn btn-sm btn-danger img-btn delete-btn">Delete</button>';
            $str .= '<button type="button" class="btn btn-sm btn-primary img-btn edit-btn">Edit</button>';
            $str .= '</div>';
            $str .= '</div>';
        }

        return $str;
    }
}
