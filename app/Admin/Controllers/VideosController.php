<?php

namespace App\Admin\Controllers;

use Modules\Media\Models\Videos;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class VideosController extends Controller
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

            $content->header('Видео');
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

            $content->header('Видео');
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

            $content->header('Видео');
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
        return Admin::grid(Videos::class, function (Grid $grid) {

            $grid->disableFilter();
            $grid->disableExport();
            $grid->id('ID')->sortable();
            $grid->column('img', 'Миниатюра')->display(function($img){
                return "<img src='{$img}' width='50' />";
            });

            $grid->column('code', "Код видео")->display(function($code){
                return "<a href='https://www.youtube.com/watch?v={$code}' target='_blank'>{$code} <i class='fa fa-external-link'></i></a>";
            });

            $grid->title();

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
        return Admin::form(Videos::class, function (Form $form) use ($id) {

            if($id) $video = Videos::find($id);

            $form->display('id', 'ID');
            $form->text("code","Код видео")->rules('required');
            if($id){
                $form->html('<img id="prew_img" src="'.($id ? $video->img : '').'" style="max-width: 300px" class="img-polaroid" />', 'Просмотр изображения');
                $form->lfm('img', 'Изображение')->prev("prew_img");
                $form->text("title")->lang();
            }

            $form->switch("active")->rules('required')->default(1);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');

            $form->saving(function (Form $form) {
                $request = request()->all();
                $request['active'] = $request['active']=='on' ? 1 : 0;
                if(!$form->model()->id){
                    $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$request['code']);
                    parse_str($content, $ytarr);
                    $request['title'] = [];
                    foreach(config('app.locales') as $loc) $request['title'][$loc] = $ytarr['title'];
                    $request['img'] = "https://img.youtube.com/vi/{$request['code']}/0.jpg";
                }

                if($form->model()->id) $v = Videos::find($form->model()->id)->update($request);
                else $v = (new Videos())->create($request);
                if($v) admin_toastr('Saved!');
                else admin_toastr('Error!', 'error');
                return redirect()->route('videos.index');
            });
        });
    }
}
