<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Lia\Controllers\Dashboard;
use Lia\Facades\Admin;
use Lia\Layout\Column;
use Lia\Layout\Content;
use Lia\Layout\Row;
use Lia\Widgets\Box;
use Lia\Addons\TranslationManager\Models\Translation;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Lia\Addons\TranslationManager\Manager;
use Lia\Addons\GoogleTranslate\TranslateClient;

class TranslateController extends Controller
{
    protected $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function google_translate(Request $request)
    {
        if(is_null($request->value)) return '';
        if(is_null($request->to_lang)) return '';
        $tr = new TranslateClient();
        return $tr->setTarget($request->to_lang)->translate($request->value);
    }

    public function getView($group = null)
    {
        return $this->getIndex($group);
    }

    public function getIndex($group = null)
    {
        $locales = $this->manager->getLocales();
        $groups = Translation::groupBy('group');
        $excludedGroups = $this->manager->getConfig('exclude_groups');
        if($excludedGroups){
            $groups->whereNotIn('group', $excludedGroups);
        }
        $groups = $groups->select('group')->get()->pluck('group', 'group');
        if ($groups instanceof Collection) {
            $groups = $groups->all();
        }
        $groups = [''=>'Choose a group'] + $groups;
        $numChanged = Translation::where('group', $group)->where('status', Translation::STATUS_CHANGED)->count();
        $allTranslations = Translation::where('group', $group)->orderBy('key', 'asc')->get();
        $numTranslations = count($allTranslations);
        $translations = [];
        foreach($allTranslations as $translation){
            $translations[$translation->key][$translation->locale] = $translation;
        }

        $view_list = view('vendor.trans.table')
            ->with('translations', $translations)
            ->with('locales', $locales)
            ->with('groups', $groups)
            ->with('group', $group)
            ->with('numTranslations', $numTranslations)
            ->with('numChanged', $numChanged)
            ->with('editUrl', route('lang.postEdit', [$group]))
            ->with('deleteEnabled', $this->manager->getConfig('delete_enabled'));

        $view_header = view('vendor.trans.header')
            ->with('groups', $groups)
            ->with('group', $group);

        return Admin::content(function (Content $content) use ($view_list,$view_header,$group,$numTranslations,$numChanged) {

            $content->header('Переводы');
            $content->description($group ? 'Группа: '.$group : '');

            $content->row(function (Row $row) use ($view_header, $group) {
                $row->column(12, (new Box('Управление', $view_header))
                    ->style('info')
                    ->addTool('<button type="submit" class="btn btn-primary btn-sm" onclick="if(confirm(\'Are you sure you want to publish the translations group '.$group.'? This will overwrite existing language files.\')) $(\'.form-publish-all\').submit()">Publish all</button>')
                );
            });
            if($group) {
                $content->row(function (Row $row) use ($view_list,$numTranslations,$numChanged) {
                    $row->column(12, (new Box("Translations, total: {$numTranslations}, changed: {$numChanged}", $view_list))
                        ->style('primary')
                        ->addTool('<button type="submit" class="btn btn-info btn-sm" onclick="if(confirm(\'Are you sure you want to publish all translations group? This will overwrite existing language files.\')) $(\'.form-publish\').submit()">Publish translations</button>')
                    );
                });
            }
        });
    }

    public function postDelete($group = null, $key)
    {
        if(!in_array($group, $this->manager->getConfig('exclude_groups')) && $this->manager->getConfig('delete_enabled')) {
            Translation::where('group', $group)->where('key', $key)->delete();
            return ['status' => 'ok'];
        }
    }

    public function postPublish($group = null)
    {
        $json = false;
        if($group === '_json'){
            $json = true;
        }
        $this->manager->exportTranslations($group, $json);
        if(request()->ajax())
            return ['status' => 'ok'];
        else
            return back();
    }

    public function postFind()
    {
        $numFound = $this->manager->findTranslations();
        return ['status' => 'ok', 'counter' => (int) $numFound];
    }

    public function postAddGroup(Request $request)
    {
        $group = str_replace(".", '', $request->input('new-group'));
        if ($group)
        {
            return redirect()->route('lang.getView',$group);
        }
        else
        {
            return redirect()->back();
        }
    }

    public function postAdd($group = null)
    {
        $keys = explode("\n", request()->get('keys'));
        foreach($keys as $key){
            $key = trim($key);
            if($group && $key){
                foreach(config('app.locales') as $loc){
                    Translation::firstOrCreate(array(
                        'locale' => $loc,
                        'group' => $group,
                        'key' => str_slug($key,'_'),
                        'value' => $key,
                        'status' => 1
                    ));
                }
            }
        }
        return redirect()->back();
    }

    public function postRemoveLocale(Request $request)
    {
        foreach ($request->input('remove-locale', []) as $locale => $val) {
            $this->manager->removeLocale($locale);
        }
        return redirect()->back();
    }

    public function postAddLocale(Request $request)
    {
        $locales = $this->manager->getLocales();
        $newLocale = str_replace([], '-', trim($request->input('new-locale')));
        if (!$newLocale || in_array($newLocale, $locales)) {
            return redirect()->back();
        }
        $this->manager->addLocale($newLocale);
        return redirect()->back();
    }

    public function postEdit($group = null)
    {
        if(!in_array($group, $this->manager->getConfig('exclude_groups'))) {
            $name = request()->get('name');
            $value = request()->get('value');
            list($locale, $key) = explode('|', $name, 2);
            $translation = Translation::firstOrNew([
                'locale' => $locale,
                'group' => $group,
                'key' => $key,
            ]);
            $translation->value = (string) $value ?: null;
            $translation->status = Translation::STATUS_CHANGED;
            $translation->save();
            return array('status' => 'ok');
        }
    }




}