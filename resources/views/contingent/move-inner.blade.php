<!-- Перевод на следующий семестр -->
<div class="header-move-contingent">
    @if($nextSemesterGroups->count())
        <div class="header-move-contingent-action">
            <div class="checkbox checkbox-styled pull-left">
                <label>
                    <input id="next-sem" value="" type="checkbox">
                    <span>Отметить все</span>
                </label>
            </div>

            <a href="#next-sem-modal" class="btn btn-xs btn-default disabled" id="next-sem-btn" data-toggle="modal">
                Перевод
                <i class="fa fa-arrow-right"></i>
            </a>

        </div>
    @endif

    <h3>Перевод на 2 семестр текущего курса</h3>
</div>

<ul class="list-course-contingent">
    @foreach($courses as $courseId => $courseTitle)
        @php($listNextSemesterGroup = $nextSemesterGroups->where('course_id', $courseId))
        @if(count($listNextSemesterGroup) > 0)
            <li>
                <div class="course-name-contingent">
                    <h4>{{$courseTitle}}</h4>

                    <a href="#" title="Отметить все группы этого курса">
                        {{ count($listNextSemesterGroup).' учебных групп' }}
                    </a>
                </div>

                <ul class="list-group-contingent">
                    @foreach($listNextSemesterGroup as $group)
                        <li class="col-sm-3">
                            <label class="checkbox-inline checkbox-styled">
                                <input value="{{$group->id}}" type="checkbox" class="sems"><span>{{ $group->title }}</span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endif
    @endforeach
    @if(!$nextSemesterGroups->count())
        <h4> в данной категории групп нет! </h4>
    @endif
</ul>

<!-- Перевод на следующий курс -->
<div class="header-move-contingent">
    @if($nextCourseGroups->count())
        <div class="header-move-contingent-action">
            <div class="checkbox checkbox-styled pull-left">
                <label>
                    <input value="" type="checkbox" id="next-course">
                    <span>Отметить все</span>
                </label>
            </div>

            <a href="#next-course-modal" class="btn btn-xs btn-default disabled" id="next-course-btn" data-toggle="modal">
                Перевод
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    @endif

    <h3>Перевод на следующий курс</h3>
</div>

<ul class="list-course-contingent">
    @foreach($courses as $courseId => $courseTitle)
        @php($listNextCourseGroup = $nextCourseGroups->where('course_id', $courseId))
        @if(count($listNextCourseGroup) > 0)
            <li>
                <div class="course-name-contingent">
                    <h4>{{$courseTitle}}</h4>

                    <a href="#" title="Отметить все группы этого курса">
                        {{ count($listNextCourseGroup).' учебных групп' }}
                    </a>
                </div>

                <ul class="list-group-contingent">
                    @foreach($listNextCourseGroup as $group)
                        <li class="col-sm-3">
                            <label class="checkbox-inline checkbox-styled">
                                <input value="{{$group->id}}" type="checkbox" class="courses" data-code="{{$group->code}}"  data-title="{{$group->title}}"><span>{{ $group->title }}</span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endif
    @endforeach

    @if(!$nextCourseGroups->count())
        <h4> в данной категории групп нет! </h4>
    @endif
</ul>

<!-- Выпускные курсы -->
<div class="header-move-contingent">
    @if($outGroups->count())
        <div class="header-move-contingent-action" id="outCourse">
            <div class="checkbox checkbox-styled pull-left">
                <label>
                    <input value="" type="checkbox" id="out-group">
                    <span>Отметить все</span>
                </label>
            </div>

            <a href="#out-modal" class="btn btn-xs btn-default disabled" id="out-group-btn" data-toggle="modal">
                Выпуск
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    @endif

    <h3>Выпускные группы</h3>
</div>

<ul class="list-course-contingent">
    @foreach($courses as $courseId => $courseTitle)
        @php($listOutCourseGroup = $outGroups->where('course_id', $courseId))
        @if(count($listOutCourseGroup) > 0)
            <li>
                <div class="course-name-contingent">
                    <h4>{{$courseTitle}}</h4>

                    <a href="#" title="Отметить все группы этого курса">
                        {{ count($listOutCourseGroup).' учебных групп' }}
                    </a>
                </div>

                <ul class="list-group-contingent">
                    @foreach($listOutCourseGroup as $group)
                        <li class="col-sm-3">
                            <label class="checkbox-inline checkbox-styled">
                                <input value="{{$group->id}}" type="checkbox" class="groups"><span>{{ $group->title }}</span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endif
    @endforeach

    @if(!$outGroups->count())
        <h4> в данной категории групп нет! </h4>
    @endif
</ul>