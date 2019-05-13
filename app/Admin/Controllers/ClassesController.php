<?php

namespace App\Admin\Controllers;

use Modules\Classes\Models\Classes;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class ClassesController extends Controller
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

            $content->header('Классы персонажей');
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

            $content->header('Классы персонажей');
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

            $content->header('Классы персонажей');
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
        return Admin::grid(Classes::class, function (Grid $grid) {

            $grid->disableFilter();
            $grid->disableExport();
            $grid->id('ID')->sortable();

            $grid->title()->sortable();
            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();

            $grid->created_at()->sortable();

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->append('<a href="'.route('classes_params.index', ['class_id' => $actions->getKey()]).'"> <i class="fa fa-area-chart"></i> Параметры</a>');
                $actions->append('<a href="'.route('classes_skills.index', ['class_id' => $actions->getKey()]).'"> <i class="fa fa-book"></i> Умения</a>');
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
        return Admin::form(Classes::class, function (Form $form) use ($id) {

            if($id) $form->display('id', 'ID');
            $form->select("img_id")->rules('required')->options([
                'knight' => 'Knight',
                'archer' => 'Archer',
                'mage' => 'Mage',
                'craft' => 'Craft',
                'paladin' => 'Paladin',
                'assassin' => 'Assassin',
                'vampire' => 'Vampire',
                'necromancy' => 'Necromancy'
            ]);
            $form->text("title","Название")->rules('required')->lang();
            $form->ckeditor("description","Описание")->rules('required')->lang();
            $form->switch("active","Status")->default("1")->rules('required');

            if($id) $form->display('created_at', 'Created At');
            if($id) $form->display('updated_at', 'Updated At');

        });
    }
}
