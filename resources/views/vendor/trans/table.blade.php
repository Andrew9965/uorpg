
<table class="table">
    <thead>
    <tr>
        <th width="15%">Key</th>
        @foreach($locales as $locale)
            <th>{{$locale}}</th>
        @endforeach
        @if($deleteEnabled)
            <th>&nbsp;</th>
        @endif
    </tr>
    </thead>
    <tbody>

    @foreach ($translations as $key => $translation)
    <tr id="{{$key}}">
        <td>{{$key}}</td>

        @foreach($locales as $locale)

        @php $t = isset($translation[$locale]) ? $translation[$locale] : null; @endphp
        <td>
            <a href="#edit"
               class="editable status-{{$t ? $t->status : 0}} locale-{{$locale}}"
               data-locale="{{$locale}}" data-name="{{$locale . "|" . $key}}"
               id="username" data-type="textarea" data-pk="{{$t ? $t->id : 0}}"
               data-url="{{$editUrl}}"
               data-title="Enter translation">{{$t ? htmlentities($t->value, ENT_QUOTES, 'UTF-8', false) : ''}}</a>
        </td>
        @endforeach
        @if($deleteEnabled)
        <td>
            <a href="{{route('lang.postDelete', [$group, $key])}}"
               class="delete-key"
               data-confirm="Are you sure you want to delete the translations for '{{$key}}?"><span
                        class="glyphicon glyphicon-trash"></span></a>
        </td>
        @endif
        <td><input class="trans_list" value='trans("{{$group}}.{{$key}}")' style="width: 100%"></td>
    </tr>
    @endforeach
    </tbody>
</table>
<script>
    $(function(){
        $(".trans_list").focus(function() {
            $(this).select();
        });
    });
</script>