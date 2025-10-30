<section> 
    <div id="commentDiv-{{$index}}">
    @if (!empty($rel))
    <flux:input id="comment-{{$index}}"  data-rel="g{{$rel}}" class="w-xl block" />
    @else
    <flux:textarea row="4" column="25" id="comment-{{$index}}" class="w-xl block" label="Teacher's General Comment" />
    @endif
    <ul class="list-group commentList hidden p-2 w-xl" id="commentList-{{$index}}" style="cursor:pointer; background:grey;">
        <li>太棒了!</li>
        <li>完全答對!</li>
        <li>再試一次!</li>
        <li>你可以的!</li>
    </ul>
    </div>
    @include('partials.homework.homework-teacher-comment-js', ['index' => $index])
</section>