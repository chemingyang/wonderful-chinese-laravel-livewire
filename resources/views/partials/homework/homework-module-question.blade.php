<div>
@if (@$type === 'fill-in-blank')
    <span>{{$type}}</span>
@elseif (@$type === 'answer-question')
    <flux:text class="mt-2" size="md">Q{{ $idx }}. {{ $question }} </flux:text>
    <flux:textarea rows="10" columns="35" label="Answer:" />
@elseif (@$type === 'sort')
    <span>{{$type}}</span>
@elseif (@$type === 'drop')
    <span>{{$type}}</span>
@elseif (@$type === 'match')
    <span>{{$type}}</span>
@else
    <span>invalid question type</span>
@endif
</div>