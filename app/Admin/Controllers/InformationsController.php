<?php

namespace App\Admin\Controllers;

use Modules\Information\Models\Informations;
use Modules\Page\Models\Pages;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class InformationsController extends Controller
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

            $content->header('Informations');
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

            $content->header('Informations');
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

            $content->header('Informations');
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
        return Admin::grid(Informations::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->disableFilter();
            $grid->disableExport();

            $grid->url("URL")->sortable();
            $grid->title()->sortable();

            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();

            $grid->created_at()->sortable();

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=false)
    {
        return Admin::form(Informations::class, function (Form $form) use ($id) {

            $form->display('id', 'ID');
            $form->select("img_id")->rules('required')->options([
                'history-hat' => 'History hat',
                'sword' => 'Sword',
                'ax' => 'Ax',
                'strong-hand' => 'Strong Hand',
                'gear' => 'Gear',
                'plus' => 'Plus',
                'eye' => 'Eye',
                'pick' => 'Pick',
                'hammer-craft' => 'Hammer Craft',
                'two-stars' => 'Two Stars',
                'artefact-sword' => 'Artefact Sword',
                'hourse' => 'Hourse',
                'stars' => 'Stars',
                'championship-cup' => 'Championship Cup',
            ]);
            $form->select('show_pages', 'Динамические страницы')->options(Pages::all()->pluck('title', 'uri'))->attribute('onchange', '$(\'[name="url"]\').val(\'/\'+$(this).val())');
            $form->text("url","URL")->rules('required')->default('/');
            $form->text("title")->rules('required')->lang();

            $form->switch("active", 'Status')->rules('required')->default(1);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
            $form->ignore('show_pages');
        });
    }
}
