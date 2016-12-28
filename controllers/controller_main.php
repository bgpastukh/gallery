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
        $data = $this->model->upload();
        echo $data;
    }

    function action_sort_date()
    {
        $data = $this->model->sortByDate();
        echo $data;
    }

    function action_sort_size()
    {
        $data = $this->model->sortBySize();
        echo $data;
    }

    function action_edit()
    {
        $this->model->edit();
    }

    function action_delete()
    {
        $this->model->delete();
    }
}
