<?php

namespace App\Http\ViewComposers;

use App\CompanyCategory;
use App\Models\MainMenu;
use Illuminate\Contracts\View\View;


class MenuComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $mainMenu;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository $users
     * @return void
     */
    public function __construct(MainMenu $mainMenu)
    {
        $this->mainMenu = $mainMenu;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('mainMenu', $this->mainMenu->getAllWithAllRelation());
    }
}