<?php

namespace App\Admin\Controllers;

use Modules\Files\Models\Files;
use Modules\Files\Models\FileCategories;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class FilesController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Файлы');
            $content->description('list');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Файлы');
            $content->description('edit');

            $content->body($this->form($id)->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('Файлы');
            $content->description('create');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        session(['category_id' => request()->category_id]);

        return Admin::grid(Files::class, function (Grid $grid) {

            $grid->disableExport();
            $grid->id('ID')->sortable();

            $grid->title()->sortable();
            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();


            $grid->created_at()->sortable();

            $grid->filter(function($filter){
                $filter->disableIdFilter();

                $filter->like('category_id', 'Категория')->select(FileCategories::all()->pluck('title', 'id'));
            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=false)
    {
        return Admin::form(Files::class, function (Form $form) use ($id) {

            $form->display('id', 'ID');

            if($id || !session('category_id')) $form->select('category_id', 'Категория')->options(FileCategories::all()->pluck('title', 'id'));
            else {
                $form->display('', 'Категория')->default(FileCategories::find(session('category_id'))->title);
                $form->hidden('category_id')->value(session('category_id'));
            }

            //$form->file("file","Файл")->rules('required');
            $form->lfm('file', 'Файл')->file();
            $form->text("title")->rules('required')->lang();
            $form->switch("recomended");
            $form->text("size");
            $form->ckeditor("description")->lang();
            $form->switch("active")->default("1")->rules('required');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
