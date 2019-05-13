<?php

namespace App\Admin\Controllers;

use App\Models\Socials;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class SocialsController extends Controller
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

            $content->header('Социальные сети');
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

            $content->header('Социальные сети');
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

            $content->header('Социальные сети');
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
        return Admin::grid(Socials::class, function (Grid $grid) {

            $grid->disableFilter();
            $grid->disableExport();
            $grid->id('ID')->sortable();

            $grid->column('img_header', 'Изображение (Шапка)')->display(function($img){
                if(!empty($img)) return "<img src='{$img}' width='50' />";
                else return 'no image';
            });

            $grid->column('img_footer', 'Изображение (Подвал)')->display(function($img){
                if(!empty($img)) return "<img src='{$img}' width='50' />";
                else return 'no image';
            });

            $grid->title();

            $grid->show_header('Показать в шапке')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();

            $grid->show_footer('Показать в подвале')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();

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
        return Admin::form(Socials::class, function (Form $form) use ( $id ) {

            $form->display('id', 'ID');

            if($id) $page = Socials::find($id);

            $form->html('<img id="prew_img_header" src="'.($id ? $page->img_header : '').'" style="max-width: 300px" class="img-polaroid" />', 'Просмотр изображения (Шапка)');
            $form->lfm('img_header', 'Изображение (Шапка)')->prev("prew_img_header");

            $form->html('<img id="prew_img_footer" src="'.($id ? $page->img_footer : '').'" style="max-width: 300px" class="img-polaroid" />', 'Просмотр изображения (Подвал)');
            $form->lfm('img_footer', 'Изображение (Подвал)')->prev("prew_img_footer");

            $form->text('title')->lang();
            $form->text('url', 'Ссылка')->lang();

            $form->switch("show_header")->default(1);
            $form->switch("show_footer")->default(1);

            $form->select('target', 'Target')->options([
                '_self' => 'Self',
                '_blank' => 'Blank',
                '_parent' => 'Parent',
                '_top' => 'Top',
            ])->rules('required')->default('_self');

            $form->switch("active")->default(1);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
