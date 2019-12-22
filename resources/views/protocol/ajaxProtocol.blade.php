@foreach ($orders as $protocol)
    <tr>
        <td>
            <a href="{{ url('dec/orders/'.$protocol->id) }}">
                {{ empty($protocol->title) ? '' : $protocol->title  }}
            </a>
        </td>

        <td>
            {{$protocol->number}}
        </td>

         <td>
            {{date('d.m.Y', strtotime($protocol->date))}}
        </td>

    </tr>
@endforeach
