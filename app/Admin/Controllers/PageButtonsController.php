<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Modules\Page\Models\Pages;
use App\Models\PageButtons;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;


class PageButtonsController extends Controller
{

    use ModelForm;

    public function index(Request $request)
    {
        if ($request->selected_page && is_numeric($request->selected_page) && Pages::find($request->selected_page)) session(['selected_page' => $request->selected_page]);
        $page_id = session('selected_page') ? session('selected_page') : $request->selected_page;

        if (!$page_id) abort(404);
        if (!$page = Pages::find($page_id)) abort(404);

        return Admin::content(function (Content $content) use ($page) {

            $content->header('Страница "' . $page->title . '"');
            $content->description('Список элементов Buttons');

            $content->body($this->grid($page));
        });
    }

    protected function grid(Pages $page)
    {
        return Admin::grid(PageButtons::class, function (Grid $grid) use ( $page ) {
            $grid->addTool('<a class="btn btn-sm btn-default" href="'.route('pages_v2.index').'"><i class="fa fa-file-code-o"></i> Страницы</a> &nbsp;&nbsp;&nbsp;');
            $grid->addTool('<a class="btn btn-sm btn-primary" href="'.route('pages_v2.edit', ['page' => $page->id]).'"><i class="fa fa-edit"></i> Редактировать страницу</a> &nbsp;&nbsp;&nbsp;');
            $grid->model()->where('page_id', $page->id);
            $grid->disableExport();

            $grid->id('ID')->sortable();

            $grid->column('img', 'Изображение')->display(function($img){
                return '<img src="'.$img.'" width="50" />';
            });

            $grid->folder('Папка')->sortable();

            $grid->title()->sortable();

            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();

            $grid->created_at()->sortable();

            $grid->filter(function($filter){
                $filter->like('folder', 'Папка')->select(PageButtons::whereNotNull('folder')->get()->pluck('folder', 'folder'));
            });

        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('"Элемент Страницы');
            $content->description('edit');

            $content->body($this->form($id)->edit($id));
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('Элемент Страницы');
            $content->description('create');

            $content->body($this->form(false));
        });
    }

    protected function form($id=false)
    {
        $page_id = session('selected_page');
        return Admin::form(PageButtons::class, function (Form $form) use ($id, $page_id) {
            $form->hidden('page_id')->value($page_id);
            if($id) $page = PageButtons::find($id);

            $form->select('show_folders', 'Существуют папки')->options(PageButtons::whereNotNull('folder')->get()->pluck('folder', 'folder'))->attribute('onchange', '$(\'[name="folder"]\').val($(this).val())')
                ->default($id ? $page->folder : '');
            $form->text('folder', 'Папка');

            $form->html('<img id="prew_img" src="'.($id ? $page->img : '').'" style="max-width: 300px" class="img-polaroid" />', 'Просмотр изображения');
            $form->lfm('img', 'Изображение')->prev("prew_img");

            $form->text("title","Название")->lang();
            $form->select('show_pages', 'Динамические страницы')->options(Pages::all()->pluck('title', 'uri'))->attribute('onchange', '$(\'[name="url"]\').val(\'/\'+$(this).val())');
            $form->text('url', 'Ссылка');
            $form->select('target', 'Target')->options([
                '_self' => 'Self',
                '_blank' => 'Blank',
                '_parent' => 'Parent',
                '_top' => 'Top',
            ])->rules('required')->default('_self');

            $form->switch("active")->default(1);
            $form->ignore(['show_folders', 'show_pages']);
        });
    }
}