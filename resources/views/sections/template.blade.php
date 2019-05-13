@if(is_file(module_path('Page').'/Resources/views/shapes/'.$page->uri.'_'.App::getLocale().'.blade.php'))
    @include('page::shapes.'.$page->uri.'_'.App::getLocale(), [
        'page' => $page,
        'collapse' => function($folder=false) use ($page){
            return htmlspecialchars_decode(view('page::types.collapse', ['page' => $page, 'folder' => $folder, 'element' => true]));
        },
        'collapse_item' => function($folder=false) use ($page){
            return htmlspecialchars_decode(view('page::types.collapse_item', ['page' => $page, 'folder' => $folder, 'element' => true]));
        },
        'header_table' => function($folder=false) use ($page){
            return htmlspecialchars_decode(view('page::types.header_table', ['page' => $page, 'folder' => $folder, 'element' => true]));
        },
        'buttons' => function($folder=false) use ($page){
            return htmlspecialchars_decode(view('page::types.buttons', ['page' => $page, 'folder' => $folder, 'element' => true]));
        }
    ])
@endif