<div class="panel-group" id="accordion">
    <div class="collapse navbar-collapse" id="app-sidebar-collapse">
        @role(['owner','admin','moderator'])
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <span class="glyphicon glyphicon-tag">&nbsp;</span>Меню</a>
                </h4>
            </div>
            <div id="collapseOne"
                 class="panel-collapse collapse {{ (Request::is('admin/menu') || Request::is('admin/menu/*') ? 'collapse in' : '') }}">
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td>
                                <span class="glyphicon glyphicon-tags"></span>
                                <a href="{{route('menu.index')}}">&nbsp;Меню</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        @endrole
        @role(['owner','admin'])
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseUser"><span
                                class="glyphicon glyphicon-user">&nbsp;</span>Пользователи<span
                                class="badge"></span></a>
                </h4>
            </div>

            <div id="collapseUser"
                 class="panel-collapse collapse {{ (Request::is('admin/users') || Request::is('admin/roles') ? 'collapse in' : '') }}">
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td>
                                <span class="glyphicon glyphicon-user text-primary"></span><a
                                        href="{{route('users.index')}}">&nbsp;Пользователи</a>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="glyphicon glyphicon-cog text-primary"></span><a
                                        href="{{route('roles.index')}}">&nbsp;Роли</a>

                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
        @endrole
        {{--<div class="panel panel-default">--}}
            {{--<div class="panel-heading">--}}
                {{--<h4 class="panel-title">--}}
                    {{--<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">--}}
                        {{--<span class="glyphicon glyphicon-folder-close">&nbsp;</span>Подразделы</a>--}}
                {{--</h4>--}}
            {{--</div>--}}
            {{--<div id="collapseTwo"--}}
                 {{--class="panel-collapse collapse {{ (Request::is('admin/subsection') || Request::is('countries') ? 'collapse in' : '') }}">--}}
                {{--<div class="panel-body">--}}
                    {{--<table class="table">--}}
                        {{--<tr>--}}
                            {{--<td>--}}
                                {{--<span class="glyphicon glyphicon-th-list text-primary"></span>--}}
                                {{--<a href="{{route('subsection.index')}}">&nbsp;Все подразделы</a>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
</div>