<?php

namespace App\Admin\Controllers;

use App\Models\Menu;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;
use Lia\Layout\Row;
use Lia\Tree;
use Modules\Page\Models\Pages;

class MenuController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index($id=false)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Меню сайта');

            $content->row(function(Row $row) use ($id) {
                if(!$id) $row->column(4, Menu::tree(function(Tree $tree){ $tree->disableCreate(); }));
                $row->column($id ? 12 : 8, $id ? $this->form($id)->edit($id) : $this->form());
            });

            //$content->body(Menu::tree());
        });
    }


    public function edit($id)
    {
        return $this->index($id);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=false)
    {
        return Admin::form(Menu::class, function (Form $form) use ($id) {
            $form->setAction('/admin/site-menu'.($id ? '/'.$id : ''));
            $form->display('id', 'ID');
            $form->select('parent_id', 'Родитель')->options(Menu::selectOptions());
            $form->text('title', 'Заголовок')->lang();
            $form->select('show_pages', 'Динамические страницы')->options(Pages::all()->pluck('title', 'uri'))->attribute('onchange', '$(\'[name="url"]\').val(\'/\'+$(this).val())');
            $form->text('url', 'Ссылка');
            $form->select('target', 'Target')->options([
                '_self' => 'Self',
                '_blank' => 'Blank',
                '_parent' => 'Parent',
                '_top' => 'Top',
            ])->rules('required')->default('_self');
            $form->switch('active')->states([
                'on'  => ['value' => 1, 'text' => 'enable', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'disable', 'color' => 'danger'],
            ])->default(1);
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
            $form->ignore('show_pages');
        });
    }
}
