<section> 
    <flux:input id="comment-{{$index}}"  data-rel="g{{$rel}}" class="w-xl block" />
    <ul class="list-group hidden p-2 w-xl" id="commentList-{{$index}}" style="cursor:pointer; background:grey;">
        <li>Awesome!</li>
        <li>Wonderful!</li>
        <li>Try Again!</li>
        <li>You Can Do It!</li>
    </ul>
    @include('partials.homework.homework-teacher-comment-js', ['index' => $index])
</section>