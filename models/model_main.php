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
        $link = $this->link;

        $query = "SELECT * FROM `gallery`";
        $result = mysqli_query($link, $query);

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

        if ($_FILES[0]['size'] > 1000000)
        {
            throw new Exception('Error! Image is to big!');
        }

        preg_match('!\.(png|jpe?g)$!i', $name, $matches);

        if (!$matches)
        {
            throw new Exception('Error! Allowed formats: jpg, jpeg, png');
        }

        if (!move_uploaded_file($_FILES[0]['tmp_name'], $uploadFile))
        {
            die( 'File was not uploaded!' );
        }

        $query = "INSERT INTO `gallery`(`name`, `date`, `comment`, `size`) VALUES ('$name', '$date', '$comment', '$size')";

        if ( !mysqli_query($link, $query) )
        {
            throw new Exception('Error! SQL-query was not performed');
        }
    }

    public function sortByDate()
    {
        $link = $this->link;
        $query = "SELECT * FROM `gallery` ORDER BY date;";
        $result = mysqli_query($link, $query);
        return $result;
    }

    public function sortBySize()
    {
        $link = $this->link;
        $query = "SELECT * FROM `gallery` ORDER BY size;";
        $result = mysqli_query($link, $query);
        return $result;
    }

    public function delete($id)
    {
        $link = $this->link;
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
}
