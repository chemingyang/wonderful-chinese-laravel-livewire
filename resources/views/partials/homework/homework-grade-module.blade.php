<flux:fieldset>
@if (@$type === 'fill-in-blank')
    <flux:label>Q{{$index}} {{$question}}</flux:label>
    <flux:input type="text" value="{{$answer}}" disabled/>
    <flux:label>Teacher's comment</flux:label>
    @include('partials.homework.homework-teacher-comment', ['index' => $index])

@elseif (@$type === 'answer-question')
    <flux:label>Q{{$index}} {{$question}}</flux:label>
    <flux:textarea rows="3" columns="10" disabled>{{$answer}}</flux:textarea>
    <flux:label>Teacher's comment</flux:label>
    @include('partials.homework.homework-teacher-comment', ['index' => $index, 'rel' => $rel])

@elseif (@$type === 'sort')
    @php
        $words = explode('|',$question);
        $order = explode(',',$answer);
        $parsedanswer = '';
        foreach ($order as $j => $ord) {
            $parsedanswer .= $ord.'. '.$words[(integer)$ord - 1].' ';
        }
    @endphp
    <flux:label>Q{{$index}} {{$question}}</flux:label>
    <flux:textarea rows="3" columns="10" disabled>{{$parsedanswer}}</flux:textarea>
    <flux:label>Teacher's comment</flux:label>
    @include('partials.homework.homework-teacher-comment', ['index' => $index])

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
    <flux:label>Q{{$index}} {{$prompt}}</flux:label>
    <flux:textarea rows="3" columns="10" disabled>{{$parsedanswer}}</flux:textarea>
    <flux:label>Teacher's comment</flux:label>
    @include('partials.homework.homework-teacher-comment', ['index' => $index])

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
    <flux:label>Q{{$index}} {{$prompt}}</flux:label>
    <flux:textarea rows="3" columns="10" disabled>{{$parsedanswer}}</flux:textarea>
    <flux:label>Teacher's comment</flux:label>
    @include('partials.homework.homework-teacher-comment', ['index' => $index])
@else
    <span>invalid question type</span>
@endif
</flux:fieldset>