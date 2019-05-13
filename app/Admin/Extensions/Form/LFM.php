<?php

namespace App\Admin\Extensions\Form;

use Lia\Form\Field;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Lia\Form\Field\PlainInput;

class LFM extends Field
{
    use PlainInput;

    protected static $js = [
        '/vendor/laravel-filemanager/js/lfm.js',
    ];

    protected $type = "image";
    protected $prev = null;

    public function file()
    {
        $this->type = "file";
    }

    public function prev($prevId=null)
    {
        $this->prev = $prevId;
    }

    public function render()
    {
        $this->initPlainInput();
        $name = $this->elementName ?: $this->formatName($this->column);

        $this->script = <<<SCRIPT

         $('.btn_{$name}').filemanager('{$this->type}', {prefix: '/admin/laravel-filemanager'});

SCRIPT;

        $this->append('<a class="btn_'.$name.'" href="#" class="btn btn-primary" data-input="'.$this->id.'" data-preview="'.$this->prev.'"><i class="fa fa-folder-o"></i></a>' )
            ->defaultAttribute('type', 'text')
            ->defaultAttribute('id', $this->id)
            ->defaultAttribute('name', $name)
            ->defaultAttribute('value', old($this->column, $this->value()))
            ->defaultAttribute('class', 'form-control '.$this->getElementClassString())
            ->defaultAttribute('placeholder', $this->getPlaceholder());


        return parent::render()->with([
            'prepend' => $this->prepend,
            'append'  => $this->append,
        ]);
    }
}