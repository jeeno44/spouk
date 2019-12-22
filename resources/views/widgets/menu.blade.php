<ul id="main-menu" class="gui-controls">
    @foreach($items as $item)
        @php
            $class = '';
            if (count($item['child']) > 0){
                 $class = 'gui-folder';

                foreach ($item['child'] as $child){
                    if ($child['uri'] == $currentUri){
                        $class = $class.' expanded active parent-active';
                        break;
                    }
                }

            }else {
                if((strpos('/'.$currentUri, $item['uri']) !== false && $item['uri'] != '/') || ($currentUri == $item['uri']))
                    $class = $class.' active parent-active';
            }
        @endphp

        <li class="{{ $class }} gui-folder">
            <a href="{{ url($item['uri']) }}">
                <div class="gui-icon"><i class="{{$item['icon']}}"></i></div>
                <span class="title">{{ $item['title'] }}</span>
            </a>

            @if( count($item['child']) > 0)
                <ul>
                    @foreach($item['child'] as $child)
                        @php($classChild = $child['uri'] == $currentUri ? 'active' : '')

                        <li class="{{ $classChild }}">
                            <a href="{{ url($child['uri']) }}">
                                <span class="title">{{ $child['title'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>


