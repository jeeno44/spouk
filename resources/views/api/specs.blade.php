<option value="">Не выбрана</option>
@foreach($out as $id => $title)
    <option value="{{$id}}">{{$title}}</option>
@endforeach