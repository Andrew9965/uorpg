<?php

namespace App\Admin\Controllers;

use Modules\Page\Models\Pages;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class PagesController extends Controller
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

            $content->header('Страницы');
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

            $content->header('Страницы');
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

            $content->header('Страницы');
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
        return Admin::grid(Pages::class, function (Grid $grid) {

            $grid->disableFilter();
            $grid->disableExport();
            $grid->id('ID')->sortable();

            $grid->uri("Ссылка")->sortable();
            $grid->title("Заголовок")->sortable();
            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();

            $grid->created_at()->sortable();

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $page = Pages::find($actions->getKey());
                if($page->control_page) $actions->append('<a href="'.route($page->control_page).'"> <i class="fa fa-cogs"></i> Параметры</a>');
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
        return Admin::form(Pages::class, function (Form $form) use ($id) {

            $form->tab('Основное', function(Form $form) use ($id){

                if($id) $form->display('id', 'ID');
                $form->text("uri","Ссылка")->placeholder("Ссылка страницы")->rules('required');
                $form->text("title","Заголовок")->rules('required')->lang();
                $form->ckeditor("content","Контент")->lang();
                $form->select('control_page', 'Страница управления')->options(function ($id) {
                    $return = [];
                    foreach (array_reverse(app()->routes->getRoutes()) as $route) {
                        if($route->methods()[0]=='GET')
                            $return[$route->getName()] = '[' . $route->getName() . '] ' . $route->uri();
                    }

                    return $return;
                });
                $form->switch("active")->default("1")->rules('required');
                if($id) $form->display('created_at', 'Created At');
                if($id) $form->display('updated_at', 'Updated At');

            })->tab('SEO', function(Form $form){

                $form->text("meta_title","Meta Title")->lang();
                $form->textarea("meta_keywords","Meta Keywords")->lang();
                $form->textarea("meta_description","Meta Description")->lang();

            });

            if($id){
                $page = Pages::find($id);
                $form->tools(function (Form\Tools $tools) use ($page) {
                    if($page->control_page) $tools->add('<a href="'.route($page->control_page).'" class="btn btn-sm btn-success"><i class="fa fa-cogs"></i> Параметры</a>&nbsp;&nbsp;&nbsp; ');
                });
            }
        });
    }
}
