<?php

namespace App\Admin\Extensions\Nav;

class Links
{
    public function __toString()
    {

        $host = request()->server('HTTP_HOST');
        $prot = request()->server("REQUEST_SCHEME");


        $new = "";


        return <<<HTML

{$new}
        
<li>
    <a href="{$prot}://{$host}/" target="_blank">
        <span class="label label-success"></span>
        Web site <i class="fa fa-external-link" aria-hidden="true"></i>
    </a>
</li>

HTML;
    }
}