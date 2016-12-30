<?php

class Model_Main extends Model
{
    public $link;

    public function connectDB()
    {
        // DB connection
        $link = mysqli_connect("database_host", "user_name", "password", "database_name");

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

//      Array for form.php
        $row = ['id' => $id, 'name' => $name, 'comment' => $comment, 'date' => $date, 'size' => $size];

        ob_start();
            include('../views/form.php');
            $data = ob_get_contents();
        ob_end_clean();

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
        $src = $_POST['src'];
        $sep = strripos($src, '/');
        $src = '/var/www.pastukh/gallery.local/www/second/public/uploads/' . substr($src, $sep + 1);
        $query = "DELETE FROM `gallery` WHERE `id` = {$id}";
        mysqli_query($link, $query);
        unlink($src);
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
        ob_start();
        while ($row = mysqli_fetch_assoc($data)) {
            include('../views/form.php');
        }
        $images = ob_get_contents();
        ob_end_clean();
        return $images;
    }
}
