<?php
use Lia\Form;
use Lia\Facades\Admin;
use App\Admin\Extensions\Form\CKEditor;
use App\Admin\Extensions\Form\LFM;

Form::forget(['map', 'editor']);
Form::extend('ckeditor', CKEditor::class);
Form::extend('lfm', LFM::class);