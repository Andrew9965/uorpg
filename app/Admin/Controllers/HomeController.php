<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Lia\Controllers\Dashboard;
use Lia\Facades\Admin;
use Lia\Layout\Column;
use Lia\Layout\Content;
use Lia\Layout\Row;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Dashboard');
            $content->description('Description...');

            $content->row(Dashboard::title());

            $content->row(function (Row $row) {

                $row->column(2, '');

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::dependencies());
                });
            });
        });
    }
}
