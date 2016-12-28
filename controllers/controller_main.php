<?php

class Controller_Main extends Controller
{
    public function __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
        $this->model->connectDB();
    }

    function action_index()
    {
        $data = $this->model->showGallery();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }

    function action_upload()
    {
        $this->model->upload();
        $data = $this->model->showGallery();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }

    function action_date()
    {
        $data = $this->model->sortByDate();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }
    function action_size()
    {
        $data = $this->model->sortBySize();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }

    function action_edit()
    {
        $this->model->edit();
    }

    function action_delete()
    {
        $url = $_SERVER['REQUEST_URI'];
        $id = substr( $url, strripos($url, '/') + 1);

        $this->model->delete($id);

        $data = $this->model->showGallery();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }
}