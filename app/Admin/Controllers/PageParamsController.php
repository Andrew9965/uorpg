<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Modules\Page\Models\Pages;
use App\Models\PagesData;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;
use Illuminate\Support\MessageBag;

class PageParamsController extends Controller {

    use ModelForm;

    public function index(Request $request)
    {
        if($request->selected_page && is_numeric($request->selected_page) && Pages::find($request->selected_page)) session(['selected_page' => $request->selected_page]);
        $page_id = session('selected_page') ? session('selected_page') : $request->selected_page;

        if(!$page_id) abort(404);
        if(!$page = Pages::find($page_id)) abort(404);

        return Admin::content(function (Content $content) use ( $page ) {

            $content->header('Страница "'.$page->title.'"');
            $content->description('Список элементов');

            $content->body($this->grid($page));
        });
    }

    protected function grid(Pages $page)
    {
        return Admin::grid(PagesData::class, function (Grid $grid) use ( $page ) {
            $grid->model()->where('page_id', $page->id);
            $grid->disableFilter();
            $grid->disableExport();
            $grid->id('ID')->sortable();

            $grid->column('data', 'Title')->display(function($data) use ( $page ){
                //return isset($data['title']) ? $data['title'][\App::getLocale()] : '';
                return $data;
            });

            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();

            $grid->created_at()->sortable();

        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Страницы');
            $content->description('edit');

            $content->body($this->form($id)->edit($id));
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('Страницы');
            $content->description('create');

            $content->body($this->form(false));
        });
    }

    protected function form($id=false)
    {
        $page_id = session('selected_page');
        return Admin::form(PagesData::class, function (Form $form) use ($id, $page_id) {
            $form->hidden('page_id')->value($page_id);

            $form->embeds('data', '', function ($form) {
                $form->image('img', 'Изображение');
                $form->text("title","Название")->lang();
                $form->ckeditor("description","Описание")->lang();
                $form->ckeditor("content","Контент")->lang();
            });

            $form->switch("active");

            /*$form->saving(function (Form $form) {

            });*/

        });
    }
}