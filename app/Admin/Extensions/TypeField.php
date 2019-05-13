<?php

namespace App\Admin\Extensions;

use Lia\Admin;
use Lia\Grid\Displayers\AbstractDisplayer;

class TypeField extends AbstractDisplayer
{
    public function display($type)
    {
        //Admin::script("$('[data-toggle=\"popover\"]').popover()");
        $value = $this->value;

        return <<<EOT
<button type="button"
    class="btn btn-secondary"
    title="popover"
    data-container="body"
    data-toggle="popover"
    data-placement="$placement"
    data-content="$value"
    >
  Popover
</button>

EOT;

    }
}