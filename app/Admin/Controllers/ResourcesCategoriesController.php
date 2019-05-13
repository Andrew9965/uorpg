<?php

namespace App\Admin\Controllers;

use Modules\Resources\Models\ResourcesCategories;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class ResourcesCategoriesController extends Controller
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

            $content->header('Категории ресурсов');
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

            $content->header('Категории ресурсов');
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

            $content->header('Категории ресурсов');
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
        return Admin::grid(ResourcesCategories::class, function (Grid $grid) {

            $grid->disableFilter();
            $grid->disableExport();
            $grid->id('ID')->sortable();

            $grid->title("Ктегория")->sortable();
            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();

            $grid->created_at()->sortable();

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->append('<a href="'.route('resources.index', ['category' => $actions->getKey()]).'"> <i class="fa fa-align-justify"></i> Ресурсы</a>');
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
        return Admin::form(ResourcesCategories::class, function (Form $form) use ($id) {

            $form->display('id', 'ID');

            $form->switch("active", 'Status')->rules('required')->default(1);
            $form->text("title","Название категории")->lang();
            $form->ckeditor('description', 'Описание')->lang();

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}