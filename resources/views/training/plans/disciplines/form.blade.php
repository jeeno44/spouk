<div class="row">
    <div class="col-sm-3">
        {!! Form::select('disciplines[]', $disciplines, null, ['class' => 'form-control']) !!}
    </div>
    <div class="col-sm-1">
        <input type="number" class="form-control" name="lecture[]">
    </div>
    <div class="col-sm-1">
        <input type="number" class="form-control" name="lab[]">
    </div>
    <div class="col-sm-1">
        <input type="number" class="form-control" name="practical[]">
    </div>
    <div class="col-sm-1">
        <input type="number" class="form-control" name="solo[]">
    </div>
    <div class="col-sm-1">
        <input type="number" class="form-control" name="exam[]">
    </div>
    <div class="col-sm-1">
        <input type="number" class="form-control" name="zet[]">
    </div>
    <div class="col-sm-1">
        <input type="number" class="form-control" name="weeks[]">
    </div>
    <div class="col-sm-1">
        {!! Form::select('controls[]', ['нет' => 'нет', 'экзамен' => 'экзамен', 'зачет' => 'зачет'], null, ['class' => 'form-control']) !!}
    </div>
    <div class="col-sm-1">
        <a class="btn btn-danger rem-disc-row btn-s pull-right" href="#"><i class="fa fa-times"></i> </a>
    </div>
</div>