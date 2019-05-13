<?php

namespace App\Admin\Controllers;

use App\Models\RightMenu;
use Modules\Page\Models\Pages;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class RightMenuController extends Controller
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

            $content->header('Правое меню');
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

            $content->header('Правое меню');
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

            $content->header('Правое меню');
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
        return Admin::grid(RightMenu::class, function (Grid $grid) {

            $grid->disableExport();
            $grid->disableFilter();
            $grid->id('ID')->sortable();

            $grid->column('img', 'Изображение')->display(function($img){
                return "<img src='{$img}' width='50' />";
            });

            $grid->title();

            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();

            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=false)
    {
        return Admin::form(RightMenu::class, function (Form $form) use ( $id ) {

            if($id) $page = RightMenu::find($id);

            $form->display('id', 'ID');

            $form->html('<img id="prew_img" src="'.($id ? $page->img : '').'" style="max-width: 300px" class="img-polaroid" />', 'Просмотр изображения');
            $form->lfm('img', 'Изображение')->prev("prew_img");

            $form->text('title')->lang();

            $form->select('show_pages', 'Динамические страницы')->options(Pages::all()->pluck('title', 'uri'))->attribute('onchange', '$(\'[name="url"]\').val(\'/\'+$(this).val())');
            $form->text('url', 'Ссылка');

            $form->select('target', 'Target')->options([
                '_self' => 'Self',
                '_blank' => 'Blank',
                '_parent' => 'Parent',
                '_top' => 'Top',
            ])->rules('required')->default('_self');

            $form->switch("active")->default(1);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');

            $form->ignore(['show_pages']);
        });
    }
}
