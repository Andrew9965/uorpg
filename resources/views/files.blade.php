@extends('layouts.app')

@section('content')
    <div class="central-section">
        <div class="content-files">
            <div class="title fix_pd">
                <h1><span>Файлы</span></h1>
            </div>
            <div class="content-classes__icons">
                <div class="icon-container"><a href="#" class="edit"><i class="ico ico-edit-icon"></i></a><a href="#" class="delete"><i class="ico ico-delete-icon"></i></a></div>
            </div>
            <div class="content-files__wrap">
                <div class="content-files__block">
                    <h2><span>Файлы для игры на сервере UORPG.net:</span></h2>
                    <div class="content-files__item">
                        <div class="content-files__item-ref"><a href="#">
                                <div class="content-files__item-img"><i class="ico ico-download-small"></i></div><span>Ultima Online ML</span></a><span>(рекомендуется)</span></div>
                        <div class="content-files__item-size"><span>591MB</span></div>
                        <div class="content-files__item-info"><span>
                        Полный дистрибутив игры Ultima Online: Mondain's Legacy (6.0.14.3) с
                        необходимыми файлами. Если Вы используете Windows 7 или Vista, то
                        рекомендуется в свойствах файла client.exe включить режим совместимости
                        с Windows 98/Me.</span></div>
                    </div>
                    <div class="content-files__item">
                        <div class="content-files__item-ref"><a href="#">
                                <div class="content-files__item-img"><i class="ico ico-download-small"></i></div><span>Update ML</span></a></div>
                        <div class="content-files__item-size"><span>227MB</span></div>
                        <div class="content-files__item-info"><span>
                        Изменённые файлы для обновления Ultima Online: Mondain's Legacy (6.0.14.3)
                        для игры на сервере.</span></div>
                    </div>
                    <div class="content-files__details"><a href="#">
                            Перейти к дополнительной настройке exe клиента 6.0.14.3
                            (мультизапуск, снятие шифрования, low CPU, игровой экран любого размера).</a>
                        <p>LoginServer=37.143.10.137,2593</p>
                    </div>
                </div>
                <div class="content-files__block">
                    <h2><span>PvP патч:</span></h2>
                    <div class="content-files__patch">
                        <p><span>Данный патч изменяет внешний вид игры специально для любителей PVP и делает сражения с другими игроками легче.</span><span>Этот патч:</span></p>
                        <ul>
                            <li>1) Убирает из игры мелкий мусор(кустики, камешки)</li>
                            <li>2) Деревья и непроходимые природные препятствия замещает пеньками</li>
                            <li>3) Стены от заклинания Wall Of Stone заменяет на низкие платформы</li>
                        </ul>
                    </div>
                    <div class="content-files__item">
                        <div class="content-files__item-ref"><a href="#">
                                <div class="content-files__item-img"><i class="ico ico-download-small"></i></div><span>pvpPatch ML</span></a></div>
                        <div class="content-files__item-size"><span>22KB</span></div>
                        <div class="content-files__item-info">
                            <div class="content-files__item-info-list"><span>Этот патч только для Ultima Online: Mondain's Legacy</span><span>Установка:</span>
                                <ul>
                                    <li>1) Закройте все окна Ultima Online!</li>
                                    <li>2) Скопируйте содержимое архива в папку игры. Запустите файл verdata2mul.exe</li>
                                    <li>3) Подождите пока обновлятся файлы и закройте окно программы.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-files__block">
                    <h2><span>Вспомогательные программы:</span></h2>
                    <div class="content-files__item">
                        <div class="content-files__item-ref"><a href="#">
                                <div class="content-files__item-img"><i class="ico ico-download-small"></i></div><span>WinRar</span></a></div>
                        <div class="content-files__item-size"><span>1.3MB</span></div>
                        <div class="content-files__item-info"><span>
                        Программа необходимая для извлечения файлов из RAR архивов,
                        представленных на этой странице.</span></div>
                    </div>
                    <div class="content-files__item">
                        <div class="content-files__item-ref"><a href="#">
                                <div class="content-files__item-img"><i class="ico ico-download-small"></i></div><span>UOpilot</span></a></div>
                        <div class="content-files__item-size"><span>567KB</span></div>
                        <div class="content-files__item-info"><span>
                        Программа, способная автоматически управлять вашим персонажем. Действия
                        программы необходимо заранее запрограммировать, используя относительно
                        простой скриптовой код.</span></div>
                    </div>
                    <div class="content-files__item">
                        <div class="content-files__item-ref"><a href="#">
                                <div class="content-files__item-img"><i class="ico ico-download-small"></i></div><span>uoloop</span></a></div>
                        <div class="content-files__item-size"><span>106KB</span></div>
                        <div class="content-files__item-info"><span>Программа, эмулирующая нажатие клавиши в окне игры с указанной частотой.</span></div>
                    </div>
                    <div class="content-files__item">
                        <div class="content-files__item-ref"><a href="#">
                                <div class="content-files__item-img"><i class="ico ico-download-small"></i></div><span>EasyUO</span></a></div>
                        <div class="content-files__item-size"><span>1MB</span></div>
                        <div class="content-files__item-info"><span>
                        Ещё одна довольна мощная полезная программа для автоматического
                        управления персонажем, имеет свой собственный скриптовой язык для
                        программирования действий.</span></div>
                    </div>
                    <div class="content-files__item">
                        <div class="content-files__item-ref"><a href="#">
                                <div class="content-files__item-img"><i class="ico ico-download-small"></i></div><span>UOAutoMap</span></a></div>
                        <div class="content-files__item-size"><span>163KB</span></div>
                        <div class="content-files__item-info"><span>
                        Программа для определения своего местоположения на карте мира
                        Ultima Online.</span></div>
                    </div>
                    <div class="content-files__item">
                        <div class="content-files__item-ref"><a href="#">
                                <div class="content-files__item-img"><i class="ico ico-download-small"></i></div><span>Razor</span></a></div>
                        <div class="content-files__item-size"><span>790KB</span></div>
                        <div class="content-files__item-info"><span>
                        Программа для Ultima Online: Mondain's Legacy (6.0.14.3). Предоставляет массу
                        полезных дополнительных функций - в их числе макрокоманды, мультизапуск
                        игры, изменение размера игрового окна и многое другое. Ошибка No CliLoc
                        является нормальной для нашего файлового пакета. Можно не обращать на нее
                        внимания. Если у Вас операционная система Windows 7/Vista, то в случае
                        нестабильной работы программы рекомендуется в свойствах запуска
                        выставить совместимость с Windows 98/Me.</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection