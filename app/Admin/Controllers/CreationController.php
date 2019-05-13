<?php

namespace App\Admin\Controllers;

use Modules\Media\Models\Creation;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class CreationController extends Controller
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

            $content->header('Творчество');
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

            $content->header('Творчество');
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
        if(!request()->type && request()->type!='video' && request()->type!='image') abort(404);

        return Admin::content(function (Content $content) {

            $content->header('Творчество');
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
        return Admin::grid(Creation::class, function (Grid $grid) {

            $grid->addTool('<a class="btn btn-sm btn-success" href="'.route('creation.create', ['type' => 'video']).'"><i class="fa fa-file-movie-o"></i> Добавить видео</a> &nbsp;&nbsp;&nbsp;');
            $grid->addTool('<a class="btn btn-sm btn-success" href="'.route('creation.create', ['type' => 'image']).'"><i class="fa fa-file-photo-o"></i> Добавить изображение</a> &nbsp;&nbsp;&nbsp;');

            $grid->disableFilter();
            $grid->disableExport();
            $grid->disableCreateButton();

            $grid->id('ID')->sortable();

            $grid->column('img', 'Миниатюра')->display(function($img){
                return "<img src='{$img}' width='50' />";
            });


            $grid->type("Тип")->label();
            $grid->title();
            $grid->active('Status')->switch()->sortable();

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
        return Admin::form(Creation::class, function (Form $form) use ($id) {

            $creation = false;
            if($id) $creation = Creation::find($id);
            $type = !$id ? request()->type : $creation->type;

            $form->display('id', 'ID');
            $form->hidden('type')->value(request()->type);

            $coll = function(&$form) use ($id, $creation){
                $form->html('<img id="prew_img" src="'.($id ? $creation->img : '').'" style="max-width: 300px" class="img-polaroid" />', 'Просмотр изображения');
                $form->lfm('img', 'Изображение')->prev("prew_img");
                $form->text("title")->lang();
            };

            if($type=='image'){
                $coll($form);
            }

            if($type=='video'){
                $form->text("code");

                if($id){
                    $coll($form);
                }
            }

            $form->switch("active")->rules('required')->default(1);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');

            $form->saving(function (Form $form) {
                $request = request()->all();
                $request['active'] = $request['active']=='on' ? 1 : 0;
                if(!$form->model()->id && request()->type=='video'){
                    $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$request['code']);
                    parse_str($content, $ytarr);
                    $request['title'] = [];
                    foreach(config('app.locales') as $loc) $request['title'][$loc] = $ytarr['title'];
                    $request['img'] = "https://img.youtube.com/vi/{$request['code']}/0.jpg";
                }

                if($form->model()->id) $v = Creation::find($form->model()->id)->update($request);
                else $v = (new Creation())->create($request);
                if($v) admin_toastr('Saved!');
                else admin_toastr('Error!', 'error');
                return redirect()->route('creation.index');
            });
        });
    }
}
