<?php

namespace App\Admin\Controllers;

use Modules\Page\Models\Pages;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;
use Lia\Widgets\Table;

class PagesV2Controller extends Controller
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

            $content->header('Страницы');
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

            $content->header('Страницы');
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

            $content->header('Страницы');
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
        return Admin::grid(Pages::class, function (Grid $grid) {
            $grid->disableFilter();
            $grid->disableExport();
            $grid->id('ID')->sortable();


            $grid->column('uri', "Ссылка")->display(function($uri){
                return "<a href='".asset($uri)."' target='_blank'>{$uri} <i class='fa fa-external-link'></i></a>";
            });

            $grid->title("Заголовок")->sortable();
            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'default'],
            ])->sortable();

            $grid->created_at()->sortable();

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $page = Pages::find($actions->getKey());
                //if($page->type) $actions->append('<a href="'.route('page_'.$page->type.'.index', ['selected_page' => $page->id]).'"> <i class="fa fa-tasks"></i> Элементы</a>');
                if($page->control_page) $actions->append('<a href="'.route($page->control_page).'"> <i class="fa fa-cogs"></i> Управление</a>');
                else {
                    $actions->append('<a href="'.route('page_collapse.index', ['selected_page' => $page->id]).'"><i class="fa fa-cogs"></i> Collapse</a>&nbsp;&nbsp;&nbsp; ');
                    $actions->append('<a href="'.route('page_collapse_item.index', ['selected_page' => $page->id]).'"><i class="fa fa-cogs"></i> Collapse Item</a>&nbsp;&nbsp;&nbsp; ');
                    $actions->append('<a href="'.route('page_header_table.index', ['selected_page' => $page->id]).'"><i class="fa fa-cogs"></i> Header Table</a>&nbsp;&nbsp;&nbsp; ');
                    $actions->append('<a href="'.route('page_buttons.index', ['selected_page' => $page->id]).'"><i class="fa fa-cogs"></i> Buttons</a>&nbsp;&nbsp;&nbsp; ');
                }
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
        return Admin::form(Pages::class, function (Form $form) use ($id) {

            $page = false;
            if($id) $page = Pages::find($id);

            if($id) $form->action(route('pages_v2.update', ['pages_v2', $id]));
            else $form->action(route('pages_v2.store'));

            $form->tab('Основное', function(Form $form) use ($id, $page){

                if($id) $form->display('id', 'ID');
                if(!$id) $form->text("uri","Ссылка")->placeholder("Ссылка страницы")->rules('required');
                else {
                    $form->display('uri', 'Ссылка');
                }
                $form->text("title","Заголовок")->rules('required')->lang();
                /*$form->select('type', 'Тип страницы')->options([
                    'collapse' => 'Collapse',
                    'collapse_item' => 'Collapse Item',
                    'header_table' => 'Header Table',
                ]);*/

                $form->ckeditor("content","Контент")->lang();

                $form->select('control_page', 'Страница управления')->options(function ($id) {
                    $return = [];
                    foreach (array_reverse(app()->routes->getRoutes()) as $route) {
                        if($route->methods()[0]=='GET')
                            $return[$route->getName()] = '[' . $route->getName() . '] ' . $route->uri();
                    }

                    return $return;
                });

                $form->switch("active")->default("1")->rules('required');
                if($id) $form->display('created_at', 'Created At');
                if($id) $form->display('updated_at', 'Updated At');

            })->tab('Шаблон', function(Form $form) use ( $id, $page ){

                $data = [];
                foreach(config('app.locales') as $loc) {
                    if($id && is_file(module_path('Page').'/Resources/views/shapes/'.$page->uri.'_'.$loc.'.blade.php'))
                        $data[$loc] = \File::get(module_path('Page').'/Resources/views/shapes/'.$page->uri.'_'.$loc.'.blade.php');
                    else
                        $data[$loc] = "";
                }


                if($id) {
                    $collapse = $page->collapse->pluck('folder', 'folder')->toArray();
                    $collapse_item = $page->collapse_item->pluck('folder', 'folder')->toArray();
                    $header_table = $page->header_table->pluck('folder', 'folder')->toArray();
                    $buttons = $page->buttons->pluck('folder', 'folder')->toArray();

                    $headers = ['Команда', 'Доступные папки на этой странице', 'Управление'];
                    $rows = [
                        ['{!!$collapse()!!}', (count($collapse) ? '{!!$collapse("' . implode('")!!}, {!!$collapse("', $collapse) . '")!!}' : ''), '<a href="' . route('page_collapse.index', ['selected_page' => $page->id]) . '" class="btn btn-sm btn-success"><i class="fa fa-cogs"></i> Collapse</a>&nbsp;&nbsp;&nbsp; '],
                        ['{!!$collapse_item()!!}', (count($collapse_item) ? '{!!$collapse_item("' . implode('")!!}, {!!$collapse_item("', $collapse_item) . '")!!}' : ''), '<a href="' . route('page_collapse_item.index', ['selected_page' => $page->id]) . '" class="btn btn-sm btn-success"><i class="fa fa-cogs"></i> Collapse Item</a>&nbsp;&nbsp;&nbsp; '],
                        ['{!!$header_table()!!}', (count($header_table) ? '{!!$header_table("' . implode('")!!}, {!!$header_table("', $header_table) . '")!!}' : ''), '<a href="' . route('page_header_table.index', ['selected_page' => $page->id]) . '" class="btn btn-sm btn-success"><i class="fa fa-cogs"></i> Header Table</a>&nbsp;&nbsp;&nbsp; '],
                        ['{!!$buttons()!!}', (count($buttons) ? '{!!$buttons("' . implode('")!!}, {!!$buttons("', $buttons) . '")!!}' : ''), '<a href="' . route('page_buttons.index', ['selected_page' => $page->id]) . '" class="btn btn-sm btn-success"><i class="fa fa-cogs"></i> Buttons</a>&nbsp;&nbsp;&nbsp; ']
                    ];
                    $table = new Table($headers, $rows);
                }
                $form->ckeditor('shape', 'Файл')->default($data)->help("\$имя_объекта(Папка если надо)<br>".($id ? $table->render():''))->lang();

            })->tab('SEO', function(Form $form){

                $form->text("meta_title","Meta Title")->lang();
                $form->textarea("meta_keywords","Meta Keywords")->lang();
                $form->textarea("meta_description","Meta Description")->lang();

            });

            $form->ignore('shape');

            $form->saving(function (Form $form) {
                foreach (request()->shape as $key => $file){
                    $relPath = module_path('Page').'/Resources/views/shapes/'.$form->model()->uri.'_'.$key.'.blade.php';
                    file_put_contents($relPath, str_replace(['&#39;'],["'"],htmlspecialchars_decode($file)));
                }
            });

            if($id){
                $form->tools(function (Form\Tools $tools) use ($page) {
                    if($page->control_page) $tools->add('<a href="'.route($page->control_page).'" class="btn btn-sm btn-success"><i class="fa fa-cogs"></i> Управление</a>&nbsp;&nbsp;&nbsp; ');
                    else {
                        $tools->add('<a href="'.route('page_collapse.index', ['selected_page' => $page->id]).'" class="btn btn-sm btn-success"><i class="fa fa-cogs"></i> Collapse</a>&nbsp;&nbsp;&nbsp; ');
                        $tools->add('<a href="'.route('page_collapse_item.index', ['selected_page' => $page->id]).'" class="btn btn-sm btn-success"><i class="fa fa-cogs"></i> Collapse Item</a>&nbsp;&nbsp;&nbsp; ');
                        $tools->add('<a href="'.route('page_header_table.index', ['selected_page' => $page->id]).'" class="btn btn-sm btn-success"><i class="fa fa-cogs"></i> Header Table</a>&nbsp;&nbsp;&nbsp; ');
                        $tools->add('<a href="'.route('page_buttons.index', ['selected_page' => $page->id]).'" class="btn btn-sm btn-success"><i class="fa fa-cogs"></i> Buttons</a>&nbsp;&nbsp;&nbsp; ');
                    }
                    //if($page->type) $tools->add('<a href="'.route('page_'.$page->type.'.index', ['selected_page' => $page->id]).'" class="btn btn-sm btn-success"><i class="fa fa-tasks"></i> Элементы</a>&nbsp;&nbsp;&nbsp; ');
                });
            }
        });
    }
}
