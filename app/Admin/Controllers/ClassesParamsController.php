<?php

namespace App\Admin\Controllers;

use Modules\Classes\Models\ClassesParams;
use Modules\Classes\Models\Classes;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class ClassesParamsController extends Controller
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

            $content->header('Параметры');
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

            $content->header('Параметры');
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

            $content->header('Параметры');
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
        session(['class_id' => request()->class_id]);

        return Admin::grid(ClassesParams::class, function (Grid $grid) {

            $grid->disableExport();
            $grid->id('ID')->sortable();
            $grid->column('class_id', 'Класс')->display(function($id){
                return Classes::find($id)->title;
            });
            $grid->title()->sortable();
            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();

            $grid->created_at()->sortable();

            $grid->filter(function($filter){
                $filter->disableIdFilter();

                $filter->like('class_id', 'Класс')->select(Classes::all()->pluck('title', 'id'));
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
        return Admin::form(ClassesParams::class, function (Form $form) use ($id) {
            $params = [];

            if($id) $params = ClassesParams::find($id)->parameters;

            if($id || !session('class_id')) $form->select('class_id', 'Класс')->options(Classes::all()->pluck('title', 'id'));
            else {
                $form->display('', 'Класс')->default(Classes::find(session('class_id'))->title);
                $form->hidden('class_id')->value(session('class_id'));
            }

            $form->text("title","Название")->rules('required')->lang();
            if(!$id)
                $form->multipleSelect('parameters')->config('tags', 'true')->config('tokenSeparators', [',', ' ']);
            else
                $form->embeds('parameters', 'Параметры', function ($form) {
                    for($i=0; $i<=12; $i++){
                        $form->number($i);
                    }
                });

            $form->switch("active","Status")->default("1")->rules('required');

            /*$form->tab('General', function(Form $form){

            })->tab('Уровни', function(Form $form){

            });*/
        });
    }
}
