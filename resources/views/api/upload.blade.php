<div class="file-item row">
    <div class="col-sm-3">
        <label class="control-label floating-label">Наименование</label>
        <input type="text" class="form-control" name="file_names[]" value="{{$name}}">
    </div>
    <div class="col-sm-3">
        <label class="control-label floating-label">Комментарий</label>
        <input type="text" class="form-control" name="file_comments[]">
        <input type="hidden" name="file_paths[]" value="{{$path}}">
        <input type="hidden" name="file_types[]" value="{{$type}}">
        <input type="hidden" name="file_sizes[]" value="{{$size}}">
    </div>
    <div class="col-sm-4">
        <label class="control-label floating-label">Тип документа</label>
        {!! Form::select('doc_types[]', \App\Models\DocType::lists('title', 'id'), null, ['class' => 'form-control']) !!}
    </div>
    <div class="col-sm-2">
        <label class="control-label floating-label">&nbsp;</label><br>
        <button type="button" class="btn btn-floating-action btn-danger remove-file btn-xs" data-path="{{$path}}"><i class="fa fa-times"></i> </button>
    </div>
</div>