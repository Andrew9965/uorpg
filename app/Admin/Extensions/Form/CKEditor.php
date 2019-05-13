<?php

namespace App\Admin\Extensions\Form;

use Lia\Form\Field;

class CKEditor extends Field
{
    public static $js = [
        '/packages/ckeditor/ckeditor.js',
        '/packages/ckeditor/adapters/jquery.js',
    ];

    protected $view = 'admin.ckeditor';

    public function render()
    {
        $this->script = <<<SCRIPT

        var options = {
            filebrowserImageBrowseUrl: '/admin/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/admin/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/admin/laravel-filemanager?type=Images',
            filebrowserUploadUrl: '/admin/laravel-filemanager/upload?type=Images&_token='
        };
        $('textarea.{$this->getElementClass()[0]}').ckeditor(options);

SCRIPT;


        return parent::render();
    }
}