<?php

namespace App\Admin\Controllers;

use App\ForumForums;
use App\ForumPosts;
use App\ForumTopics;
use App\ForumUsers;
use App\Models\Options;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Lia\Auth\Database\Administrator;
use Modules\News\Models\News;

use Lia\Form;
use Lia\Grid;
use Lia\Facades\Admin;
use Lia\Layout\Content;
use App\Http\Controllers\Controller;
use Lia\Controllers\ModelForm;
use Lia\Widgets\Form as WForm;

use Converter\Converter;

class NewsController extends Controller
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

            $content->header('Новости');
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

            $content->header('Новости');
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

            $content->header('Новости');
            $content->description('create');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    public function forum_save(Request $request)
    {
        $request = $request->all();
        $data_ru = Options::where('name', 'show.forums.ru')->first();
        $data_en = Options::where('name', 'show.forums.en')->first();
        $data_ru->value = implode(',',array_diff($request['value']['ru'], [null]));
        $data_en->value = implode(',',array_diff($request['value']['en'], [null]));

        if($data_ru->save() && $data_en->save())
            admin_toastr('Forum data saved!');
        else
            admin_toastr('Error forum data saved!', 'error');

        return redirect()->route('news.index');
        dd($request);
    }

    protected function grid()
    {
        return Admin::grid(News::class, function (Grid $grid) {

            $grid->addTool("<a class='btn btn-sm btn-success' style='margin-right: 10px' data-toggle='modal' data-target='#forum-modal'><i class='fa fa-cogs'></i>&nbsp;&nbsp;Форум</a>");
            $data = Options::where('name', 'like', 'show.forums.%')->get()->pluck('value', 'name')->toArray();
            //dd($data);
            $form = (new WForm(false))->hideBtns()->route('save_forum_cfg')->method()->attribute(['id' => 'forum_cfg']);
            $form->tags('value.ru', 'Русский')->options(ForumForums::all()->pluck('forum_name', 'forum_id'))->values($data['show.forums.ru']);
            $form->tags('value.en', 'English')->options(ForumForums::all()->pluck('forum_name', 'forum_id'))->values($data['show.forums.en']);
            $modal = <<<HTML
<div class="modal fade" id="forum-modal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cogs"></i> Открытые разделы форума</h4>
            </div>
            
            <div class="modal-body">
                {$form->render()}
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submit" data-dismiss="modal" onclick="$('#forum_cfg').submit();">Сохранить</button>
                <button type="reset" data-dismiss="modal" class="btn btn-warning pull-left">Отмена</button>
            </div>
            
        </div>
    </div>
</div>
HTML;

            $grid->addTool($modal);

            $grid->disableExport();
            $grid->id('ID')->sortable();

            $grid->title("Заголовок")->sortable();
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
        if(!\Admin::user()->forum_){
            $error = new MessageBag([
                'title' => 'Ошибка',
                'message' => "Для начала укажите какой пользователь форума пренадлежит вам, <a href='".route('users.edit', ['user' => \Admin::user()->id])."'>(Редактировать)</a>"
            ]);
            return back()->with(compact('error'));
        }

        return Admin::form(News::class, function (Form $form) use ($id) {

            $form->display('id', 'ID');
            if($id) $form->text("forum_link","Ссылка на форум")->rules('required')->lang()->removeTranslateBtn();
            //$form->select('author_id', 'Автор')->options(ForumUsers::all()->pluck('username', 'user_id'))->default(\Admin::user()->forum_);
            $user = ForumUsers::find(\Admin::user()->forum_);

            $form->select('forum_id', 'Форум')
                ->options(ForumForums::all()->pluck('forum_name', 'forum_id'))
                ->rules('required')
                ->default(['ru' => config('default.forum.id.ru', 0), 'en' => config('default.forum.id.en', 0)])
                ->lang()
                ->removeTranslateBtn();

            $form->display('forum_user_id', 'Пользователь форума')->default($id ? ForumUsers::find(News::find($id)->author_id)->username : $user->username)->help("
                Можно отредактировать <a href='".route('users.edit', ['user' => \Admin::user()->id])."'>тут</a>
            ");
            $form->hidden('author_id')->value(\Admin::user()->forum_);

            $form->text("title","Заголовок")->rules('required')->lang();
            $form->ckeditor("content","Новость")->rules('required')->lang();
            $form->switch('active')->states([
                'on'  => ['value' => 1, 'text' => 'On', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'Off', 'color' => 'danger'],
            ])->default(1);

            $form->switch('forum_post', 'Отправить копию на форум?')->default(1)->states([
                'on'  => ['value' => 1, 'text' => 'Yes', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'NO', 'color' => 'default'],
            ]);

            $form->ignore(['forum_id', 'forum_user_id', 'forum_post']);

            $form->saving(function(Form $form){
                $request = request();
                $form->model()->author_id = \Admin::user()->forum_;
                //dd($form->model());
                if(!$request->news && $request->forum_post=='on'){
                    //dd($request->forum_id );
                    $links = [];
                    foreach ($request->forum_id as $lang => $forum_id){
                        /*$content = str_replace('<p','<p style="font-size: inherit;"', isset($request->all()['content'][$lang]) && !empty($request->all()['content'][$lang]) ? $request->all()['content'][$lang] : '');
                        $content = str_replace(["<br>", "<br />", "<br/>"], "", $content);*/
                        $bbcode_uid = substr(md5($lang), 0, 5);
                        /*$c = (new \Converter\HTMLConverter($request->all()['content'][$lang], $bbcode_uid))->toBBCode();*/

                        $c = $this->html_bbcode_format($request->all()['content'][$lang], $bbcode_uid);
                        $c = (new \Converter\HTMLConverter($c, $bbcode_uid))->toBBCode();
                        $pattern = "/\[(.+?)\]/";
                        $replacement = "[\${1}:{$bbcode_uid}]";
                        $content = preg_replace($pattern, $replacement, str_replace(":{$bbcode_uid}",'',$c));
                        //$content = str_replace('[list=1', '[list', $content);
                        //dd($content);

                        $user = ForumUsers::find($request->author_id);
                        $t_data = [
                            "forum_id" => $forum_id,
                            "topic_title" => isset($request->title[$lang]) && !empty($request->title[$lang]) ? $request->title[$lang] : '',
                            "topic_poster" => $request->author_id,
                            "topic_time" => time(),

                            "topic_first_post_id" => 0,
                            "topic_last_post_id" => 0,

                            "topic_first_poster_name" => $user->username,
                            "topic_last_poster_name" => $user->username,
                            "topic_last_poster_id" => $request->author_id,

                            "topic_last_poster_colour" => $user->user_colour,
                            "topic_first_poster_colour" => $user->user_colour,

                            "topic_last_post_subject" => isset($request->title[$lang]) && !empty($request->title[$lang]) ? $request->title[$lang] : '',
                            "topic_last_post_time" => time(),
                            "topic_last_view_time" => time()
                        ];
                        $topic = ForumTopics::create($t_data);

                        $post = ForumPosts::create([
                            'topic_id' => $topic->topic_id,
                            'forum_id' => $forum_id,
                            'poster_id' => $request->author_id,
                            'poster_ip' => $request->ip(),
                            'post_time' => time(),
                            'post_username' => $user->username,
                            'post_subject' => isset($request->title[$lang]) && !empty($request->title[$lang]) ? $request->title[$lang] : '',
                            'post_text' => $content,
                            'post_checksum' => md5(isset($request->title[$lang]) && !empty($request->title[$lang]) ? $request->title[$lang] : ''),
                            'bbcode_uid' => $bbcode_uid
                        ]);

                        ForumForums::find($forum_id)->update([
                            "forum_last_post_id" => $post->post_id,
                            "forum_last_poster_id" => $request->author_id,
                            "forum_last_post_subject" => isset($request->title[$lang]) && !empty($request->title[$lang]) ? $request->title[$lang] : '',
                            "forum_last_post_time" => time(),
                            "forum_last_poster_name" => $user->username,
                            "forum_last_poster_colour" => $user->user_colour
                        ]);
                        $topic->topic_first_post_id = $post->post_id;
                        $topic->topic_last_post_id = $post->post_id;
                        $topic->save();

                        $links[$lang] = trim(config('default.forum.url'), '/')."/viewtopic.php?f={$forum_id}&t={$topic->topic_id}";
                    }

                    $form->model()->forum_link = $links;
                }
            });

            /*$form->saved(function (Form $form) {
                $form->model()->author_id = \Admin::user()->forum_;
                $form->model()->save();
            });*/

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    private function html_bbcode_format ($replace, $bbcode_uid) {
        $replace = htmlspecialchars_decode($replace);
        $replace = str_replace(';;','',$replace);
        $replace = str_replace('"','"',$replace);
        $replace = str_replace('<','<',$replace);
        $replace = str_replace('>','>',$replace);
        $replace = str_replace('<br />','',$replace);
        $replace = preg_replace('</div>', '', $replace);
        //$replace = preg_replace('<p (.*?)>', '', $replace);
        $replace = preg_replace('<div align="(.*?)">', '', $replace);
        $replace = preg_replace('<img src="(.*?)"(.*?) />', '[img:'.$bbcode_uid.']$1[/img:'.$bbcode_uid.']', $replace);
        $replace = preg_replace('<img(.*?)src="(.*?)">', '[img:'.$bbcode_uid.']$2[/img:'.$bbcode_uid.']', $replace);
        $replace = preg_replace('/\<font size=\"([1-7])\"\>((\s|.)+?)\<\/font>/i', '[size=\\1:'.$bbcode_uid.']\\2[/size:'.$bbcode_uid.']', $replace);
        $replace = preg_replace('/\<span size=\"([1-7])\"\>((\s|.)+?)\<\/span>/i', '[size=\\1:'.$bbcode_uid.']\\2[/size:'.$bbcode_uid.']', $replace);

        //$replace = preg_replace('/\<span style=\"font-size\:(.+?)px\"\>((\s|.)+?)\<\/span>/i', '[size="\\1px":'.$bbcode_uid.']\\2[/size:'.$bbcode_uid.']', $replace);
        $replace = preg_replace('/\<span style=\"font-size\:(.+?)px\"\>((\s|.)+?)\<\/span>/i', '\\2', $replace);


        $replace = preg_replace('/\<font color=\"(#[a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9])\"\>((\s|.)+?)\<\/font>/i', '[color=\\1:'.$bbcode_uid.']\\2[/color:'.$bbcode_uid.']', $replace);
        $replace = preg_replace('/\<font color=\"([a-zA-Z]+)\]((\s|.)+?)\<\/font>/i', '[color=\\1:'.$bbcode_uid.']\\2[/color:'.$bbcode_uid.']', $replace);
        $replace = preg_replace('/\<span style=\"color:(#[a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9])\"\>((\s|.)+?)\<\/span>/i', '[color=\\1:'.$bbcode_uid.']\\2[/color:'.$bbcode_uid.']', $replace);
        $replace = preg_replace('/\<span style=\"color:([a-zA-Z]+)\]((\s|.)+?)\<\/span>/i', '[color=\\1:'.$bbcode_uid.']\\2[/color:'.$bbcode_uid.']', $replace);
        $replace = preg_replace("/\<a href=\"((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\">((\s|.)+?)\<\/a\>/i","[url=\\1:{$bbcode_uid}]\\3[/url:{$bbcode_uid}]", $replace);
        $replace = str_replace('<i>','[i:'.$bbcode_uid.']',$replace);
        $replace = str_replace('</i>','[/i:'.$bbcode_uid.']',$replace);
        $replace = str_replace('<em>','[i:'.$bbcode_uid.']',$replace);
        $replace = str_replace('</em>','[/i:'.$bbcode_uid.']',$replace);
        $replace = str_replace('<s>','[s:'.$bbcode_uid.']',$replace);
        $replace = str_replace('</s>','[/s:'.$bbcode_uid.']',$replace);
        $replace = str_replace('<sub>','[sub:'.$bbcode_uid.']',$replace);
        $replace = str_replace('</sub>','[/sub:'.$bbcode_uid.']',$replace);
        $replace = str_replace('<sup>','[sup:'.$bbcode_uid.']',$replace);
        $replace = str_replace('</sup>','[/sup:'.$bbcode_uid.']',$replace);
        $replace = str_replace('<b>','[b:'.$bbcode_uid.']',$replace);
        $replace = str_replace('</b>','[/b:'.$bbcode_uid.']',$replace);
        $replace = str_replace('<strong>','[b:'.$bbcode_uid.']',$replace);
        $replace = str_replace('</strong>','[/b:'.$bbcode_uid.']',$replace);
        $replace = str_replace('<blockquote>','[quote:'.$bbcode_uid.']',$replace);
        $replace = str_replace('</blockquote>','[/quote:'.$bbcode_uid.']',$replace);
        $replace = str_replace('<u>','[u:'.$bbcode_uid.']',$replace);
        $replace = str_replace('</u>','[/u:'.$bbcode_uid.']',$replace);
        $replace = preg_replace('/\<span (.*?)>(.*?)<\/span>/', '\\2', $replace);
        $replace = preg_replace('/\<p (.*?)>(.*?)(<\/p>|)/', '\\2', $replace);
        $replace = str_replace(['<p>','</p>'],'',$replace);

        /*$replace = str_replace('<','',$replace);
        $replace = str_replace('/>','',$replace);
        $replace = str_replace('>','',$replace);*/

        $replace = str_replace('&nbsp;',' ',$replace);
        return $replace;
    }

    private function list_inner_loop($text, $num=1){
        //if(strpos($text, $findme))
    }
}
