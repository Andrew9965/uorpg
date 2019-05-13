<style>
    a.status-1{
        font-weight: bold;
    }
</style>
<script>
    jQuery(document).ready(function($){
        $.ajaxSetup({
            beforeSend: function(xhr, settings) {
                settings.data += "&_token=<?php echo csrf_token() ?>";
            }
        });

        function translate(obj){
            NProgress.start();
            var locale = $(obj).parents('td').find('[data-locale]').data('locale');
            var text = $(obj).parents('.control-group').find('textarea').val();
            $.get('{{route('lang.google_translate')}}', {to_lang:locale, value:text}, function(result){
                $(obj).parents('.control-group').find('textarea').val(result);
                NProgress.done();
            });
        }

        $.fn.editableform.buttons = '<button type="submit" class="btn btn-primary btn-sm editable-submit"><i class="glyphicon glyphicon-ok"></i></button>' +
                                '<button type="button" class="btn btn-default btn-sm editable-cancel"><i class="glyphicon glyphicon-remove"></i></button><br><br>' +
                                '<button type="button" class="btn btn-success btn-sm this_translate"><i class="fa fa-language"></i> Перевести</button>';

        $('.editable').editable().on('hidden', function(e, reason){
            var locale = $(this).data('locale');
            if(reason === 'save'){
                $(this).removeClass('status-0').addClass('status-1');
            }
            if(reason === 'save' || reason === 'nochange') {
                var $next = $(this).closest('tr').next().find('.editable.locale-'+locale);
                /*setTimeout(function() {
                    $next.editable('show');
                }, 300);*/
            }
        });

        $('.editable').editable().on('shown', function(e, reason){
            $('.this_translate').on('click', function(){
                translate(this);
            });
        });

        $('.group-select').on('change', function(){
            var group = $(this).val();
            if (group) {
                window.location.href = '{{route('lang.getView')}}/'+$(this).val();
            } else {
                window.location.href = '{{route('lang.getIndex')}}';
            }
        });
        $("a.delete-key").click(function(event){
            event.preventDefault();
            var row = $(this).closest('tr');
            var url = $(this).attr('href');
            var id = row.attr('id');
            $.post( url, {id: id}, function(){
                row.remove();
            } );
        });
        $('.form-import').on('ajax:success', function (e, data) {
            $('div.success-import strong.counter').text(data.counter);
            $('div.success-import').slideDown();
            window.location.reload();
        });
        $('.form-find').on('ajax:success', function (e, data) {
            $('div.success-find strong.counter').text(data.counter);
            $('div.success-find').slideDown();
            window.location.reload();
        });
        $('.form-publish').on('ajax:success', function (e, data) {
            $('div.success-publish').slideDown();
        });
        $('.form-publish-all').on('ajax:success', function (e, data) {
            $('div.success-publish-all').slideDown();
        });
    })
</script>
<div class="container-fluid">
    @if(Session::has('successPublish'))
        <div class="alert alert-info">
            {{Session::get('successPublish')}}
        </div>
    @endif
</div>

<div class="row">
        <div class="col-md-6">
                <div class="form-group">
                        <label>Выберите группу для отображения групповых переводов</label>
                        <select name="group" id="group" class="form-control group-select">
                                @foreach($groups as $key => $value)
                                        <option value="{{$key}}"{{$key == $group ? ' selected':''}}>{{$value}}</option>
                                @endforeach
                        </select>
                </div>
                @if($group)
                <form action="{{route('lang.postAdd', [$group])}}" method="POST"  role="form">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="form-group">
                                <label>Добавить новые ключи в эту группу</label>
                                <textarea class="form-control" rows="3" name="keys" placeholder="Add 1 key per line, without the group prefix"></textarea>
                        </div>
                        <div class="form-group">
                                <input type="submit" value="Add keys" class="btn btn-primary">
                        </div>
                </form>
                @endif
        </div>
        <div class="col-md-6">
                <form role="form" method="POST" action="{{route('lang.postAddGroup')}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                                <label>Введите новое имя группы и начните редактировать переводы в этой группе</label>
                                <input type="text" class="form-control" name="new-group" />
                        </div>
                        <div class="form-group">
                                <input type="submit" class="btn btn-default" name="add-group" value="Add and edit keys" />
                        </div>
                </form>
        </div>
</div>

<form class="form-inline form-publish-all" method="POST" action="{{route('lang.postPublish', '*')}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
</form>
<form class="form-inline form-publish" method="POST" action="{{route('lang.postPublish', $group)}}">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
</form>