<?php

namespace App\Admin\Controllers;

use Modules\Resources\Models\Resources;
use Modules\Resources\Models\ResourcesCategories;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class ResourcesController extends Controller
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

            $content->header('Ресурсы');
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

            $content->header('Ресурсы');
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

            $content->header('Ресурсы');
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
        return Admin::grid(Resources::class, function (Grid $grid) {

            $grid->disableExport();
            $grid->id('ID')->sortable();

            $grid->title("Название")->sortable();
            $grid->character_level("Уровень персонажа")->sortable();
            $grid->skills_for_extraction("Умения для добычи")->sortable();
            $grid->skills_for_processing("Умения для обработки")->sortable();
            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();

            $grid->created_at()->sortable();

            $grid->filter(function($filter){
                $filter->disableIdFilter();

                $filter->like('category', 'Категория')->select(ResourcesCategories::all()->pluck('title', 'id'));
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
        return Admin::form(Resources::class, function (Form $form) use ($id) {

            $form->display('id', 'ID');
            $form->select("category","Категория")->rules('required')->options(ResourcesCategories::where('active',1)->get()->pluck('title', 'id'));
            $form->select("img_id","IMG ID")->rules('required')->options([
                'iron' => 'Iron',
                'copper' => 'Copper',
                'bronze' => 'Bronze',
                'steel' => 'Steel',
                'black-steel' => 'Black Steel',
                'meteor' => 'Meteor',
                'dark-crystal' => 'Dark Crystal',
                'lava' => 'Lava',
                'elemental' => 'Elemental',
                'mithril' => 'Mithril',
                'dragon' => 'Dragon',
                'holy' => 'Holy'
            ]);
            $form->text("title","Название категории")->rules('required')->lang();
            $form->number("character_level","Уровень персонажа")->rules('required');
            $form->text("skills_for_extraction","Умения для добычи")->default("0.0")->rules('required');
            $form->text("skills_for_processing","Умения для обработки")->default("0.0")->rules('required');
            $form->ckeditor("description","Свойства металлического оружия и доспехов")->rules('required')->lang();
            $form->switch("active")->rules('required')->default(1);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
