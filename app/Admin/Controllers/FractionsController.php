<?php

namespace App\Admin\Controllers;

use Modules\Fractions\Models\Fractions;
use Modules\Fractions\Models\FractionsCategories;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;

class FractionsController extends Controller
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

            $content->header('Фракции');
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

            $content->header('Фракции');
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

            $content->header('Фракции');
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
        session(['category_id' => request()->category_id]);

        return Admin::grid(Fractions::class, function (Grid $grid) {

            $grid->disableExport();
            $grid->id('ID')->sortable();

            $grid->title();

            $grid->created_at()->sortable();

            $grid->filter(function($filter){
                $filter->disableIdFilter();

                $filter->like('category_id', 'Категория')->select(FractionsCategories::all()->pluck('title', 'id'));
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
        return Admin::form(Fractions::class, function (Form $form) use ($id) {

            $form->display('id', 'ID');

            if($id || !session('category_id')) $form->select('category_id', 'Категория')->options(FractionsCategories::all()->pluck('title', 'id'));
            else {
                $form->display('', 'Категория')->default(FractionsCategories::find(session('category_id'))->title);
                $form->hidden('category_id')->value(session('category_id'));
            }

            $form->select("img_id")->rules('required')->options([
                'fraction-empire' => 'Fraction Empire',
                'fraction-ins' => 'Fraction Ins',
                'fraction-chaos' => 'Fraction Chaos',
                'fraction-darkness' => 'Fraction Darkness',
                'fraction-notin' => 'Fraction Notin',
            ]);
            $form->text("title")->rules('required')->lang();
            $form->ckeditor("description")->lang();
            $form->text("signature")->lang();
            $form->text("class");
            $form->switch("active")->default(1);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
