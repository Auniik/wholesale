@if(Session::has('menu'))
    <?
    $id = Session::get('menu');
    $subMenu = \App\Models\SubMenu::where(['status'=>1,'fk_menu_id'=>$id])->orderBy('serial_num','ASC')->limit(7)->get();
    ?>
    @foreach($subMenu as $sMenu)
        <?
        $subSubMenu = $sMenu->subSubMenu->where('status',1);
        ?>

        <li class="dropdown">
            <a href='{{URL::to("$sMenu->url")}}' @if(count($subSubMenu)>0) class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" @endif>
                <i class="fa fa-folder"></i> {{$sMenu->name}} @if(count($subSubMenu)>0) <span class="caret"></span> @endif
            </a>
            @if(count($subSubMenu)>0)
                <ul class="dropdown-menu" style=" border-radius:0px !important;">
                    @foreach($subSubMenu as $ssMenu)
                        <li> <a href='{{URL::to("$ssMenu->url")}}'> <i class="fa fa-folder-open"></i> {{ $ssMenu->name }} </a> </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
@endif