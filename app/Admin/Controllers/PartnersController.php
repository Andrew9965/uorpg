<?php

namespace App\Admin\Controllers;

use App\Models\Partners;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class PartnersController extends Controller
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

            $content->header('Партнеры');
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

            $content->header('Партнеры');
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

            $content->header('Партнеры');
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
        return Admin::grid(Partners::class, function (Grid $grid) {

            $grid->disableExport();
            $grid->disableFilter();

            $grid->id('ID')->sortable();
            $grid->column('img', 'Изображение')->display(function($img){
                return '<img src="'.asset($img).'" />';
            });
            $grid->link()->sortable();
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
        return Admin::form(Partners::class, function (Form $form) use ($id) {

            if($id) $page = Partners::find($id);
            $form->html('<img id="prew_img" src="'.($id ? $page->img : '').'" style="max-width: 300px" class="img-polaroid" />', 'Просмотр изображения');
            $form->lfm('img', 'Изображение')->prev("prew_img");
            $form->select('target', 'Target')->options([
                '_self' => 'Self',
                '_blank' => 'Blank',
                '_parent' => 'Parent',
                '_top' => 'Top',
            ])->rules('required');
            $form->text("link","Ссылка")->lang()->removeTranslateBtn();
            $form->text("title","Title")->lang();
            $form->text("alt","Alt")->lang();
            $form->switch("active","Status")->default("1")->rules('required');

        });
    }
}
