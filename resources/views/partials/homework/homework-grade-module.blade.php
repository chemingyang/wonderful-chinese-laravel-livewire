<flux:fieldset>
<script>
    /* for the teacher comment section */
    var commentID = {};
    var commentListID = {};
    var commentDivID = {};
    var commentArea = {};
    var commentList = {};
    var commentDiv = {};
</script>
@if (@$type === 'fill-in-blank')
    <flux:label class="w-full">Q{{$index}} {{$question}}</flux:label>
    <flux:input type="text" value="{{$answer}}" disabled class="w-xl inline-block"/>
    @if (@$matched = $answer == $answerkey)
    <div class="justify-end inline-block w-12">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
        </svg>
    </div>
    @endif
    <flux:label class="w-full">Teacher's comment</flux:label>
    @include('partials.homework.homework-teacher-comment', ['matched' => $matched])

@elseif (@$type === 'answer-question')
    <flux:label class="w-full">Q{{$index}} {{$question}}</flux:label>
    <flux:textarea rows="3" columns="10" disabled class="w-xl inline-block">{{$answer}}</flux:textarea>
    @if ($matched = $answer == $answerkey)
    <div class="justify-end inline-block w-12">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
        </svg>
    </div>
    @endif
    <flux:label class="w-full">Teacher's comment</flux:label>
    @include('partials.homework.homework-teacher-comment', ['matched' => $matched])
@elseif (@$type === 'sort')
    @php
        $words = explode('|',$question);
        $order = explode(',',$answer);
        $parsedanswer = '';
        foreach ($order as $j => $ord) {
            $parsedanswer .= $ord.'. '.$words[(integer)$ord - 1].' ';
        }
    @endphp
    <flux:label class="w-full">Q{{$index}} {{$question}}</flux:label>
    <flux:input type="text" value="{{$parsedanswer}}" class="w-xl inline-block" />
    @if (@$matched = $answer == $answerkey)
    <div class="justify-end inline-block w-12">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
        </svg>
    </div>
    @endif
    <flux:label class="w-full">Teacher's comment</flux:label>
    @include('partials.homework.homework-teacher-comment', ['matched' => $matched])

@elseif (@$type === 'drop')
    @php
        $qparts = explode(':',$question);
        $words = explode('|',$qparts[1]);
        $prompt = $qparts[0];
        $order = explode(',',$answer);
        $parsedanswer = '';
        foreach ($order as $j => $ord) {
            $parsedanswer .= $ord.'. '.$words[(integer)$ord - 1].' ';
        }
    @endphp
    <flux:label class="w-full">Q{{$index}} {{$prompt}}</flux:label>
    <flux:input type="text" value="{{$parsedanswer}}" disabled class="w-xl inline-block" />
    @if (@$matched = sort(explode(',',$answer)) == sort(explode(',',$answerkey)))
    <div class="justify-end inline-block w-12">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
        </svg>
    </div>
    @endif
    <flux:label class="w-full">Teacher's comment</flux:label>
    @include('partials.homework.homework-teacher-comment', ['matched' => $matched])

@elseif (@$type === 'match')
    @php
        $qparts = explode(':',$question);
        $words = explode('|',$qparts[1]);
        $prompt = $qparts[0];
        $order = explode(',',$answer);
        $parsedanswer = '';
        foreach ($order as $j => $ord) {
            $parsedanswer .= $ord.'. '.$words[(integer)$ord - 1].' ';
        }
    @endphp
    <flux:label class="w-full">Q{{$index}} {{$prompt}}</flux:label>
    <flux:input type="text" value="{{$parsedanswer}}" disabled class="w-xl inline-block" />
    @if (@$matched = $answer == $answerkey)
    <div class="justify-end inline-block w-12">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
        </svg>
    </div>
    @endif
    <flux:label class="w-full">Teacher's comment</flux:label>
     @include('partials.homework.homework-teacher-comment', ['matched' => $matched])
@else
    <span>invalid question type</span>
@endif
</flux:fieldset>