<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Modules\Page\Models\Pages;
use App\Models\PageCollapseItem;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;


class PageCollapseItemController extends Controller
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
            $content->description('Список элементов Collapse Item');

            $content->body($this->grid($page));
        });
    }

    protected function grid(Pages $page)
    {
        return Admin::grid(PageCollapseItem::class, function (Grid $grid) use ( $page ) {
            $grid->addTool('<a class="btn btn-sm btn-default" href="'.route('pages_v2.index').'"><i class="fa fa-file-code-o"></i> Страницы</a> &nbsp;&nbsp;&nbsp;');
            $grid->addTool('<a class="btn btn-sm btn-primary" href="'.route('pages_v2.edit', ['page' => $page->id]).'"><i class="fa fa-edit"></i> Редактировать страницу</a> &nbsp;&nbsp;&nbsp;');
            $grid->model()->where('page_id', $page->id);
            $grid->disableExport();

            $grid->id('ID')->sortable();
            $grid->folder('Папка')->sortable();

            $grid->title()->sortable();

            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();

            $grid->created_at()->sortable();

            $grid->filter(function($filter){
                $filter->like('folder', 'Папка')->select(PageCollapseItem::whereNotNull('folder')->get()->pluck('folder', 'folder'));
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
        return Admin::form(PageCollapseItem::class, function (Form $form) use ($id, $page_id) {
            $form->hidden('page_id')->value($page_id);

            $form->select('show_folders', 'Существуют папки')->options(PageCollapseItem::whereNotNull('folder')->get()->pluck('folder', 'folder'))->attribute('onchange', '$(\'[name="folder"]\').val($(this).val())')
                ->default($id ? PageCollapseItem::find($id)->folder : '');
            $form->text('folder', 'Папка');

            $form->color('color', 'Цвет')->rgba()->default('rgba(43,18,17,0.5)');

            $form->text("title","Название")->lang();
            $form->ckeditor("content","Контент")->lang();

            $form->switch("active")->default(1);
            $form->ignore('show_folders');
        });
    }
}