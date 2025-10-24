<flux:fieldset>
@if (@$type === 'fill-in-blank')
    <flux:label>Q{{$index}} {{$question}}</flux:label>
    <flux:input type="text" value="{{$answer}}" disabled/>
    <flux:label>Teacher's comment</flux:label>
    <flux:textarea rows="5" columns="15" />
@elseif (@$type === 'answer-question')
    <flux:label>Q{{$index}} {{$question}}</flux:label>
    <flux:textarea rows="5" columns="15" disabled>{{$answer}}</flux:textarea>
    <flux:label>Teacher's comment</flux:label>
    <flux:textarea rows="5" columns="15" />
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
    <flux:textarea rows="5" columns="15" disabled>{{$parsedanswer}}</flux:textarea>
    <flux:label>Teacher's comment</flux:label>
    <flux:textarea rows="5" columns="15" />
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
    <flux:textarea rows="5" columns="15" disabled>{{$parsedanswer}}</flux:textarea>
    <flux:label>Teacher's comment</flux:label>
    <flux:textarea rows="5" columns="15" />

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
    <flux:textarea rows="5" columns="15" disabled>{{$parsedanswer}}</flux:textarea>
    <flux:label>Teacher's comment</flux:label>
    <flux:textarea id="comment-{{$index}}" rows="5" columns="15" />
    <ul class="list-group hidden m-2 p-2" id="commentListID" style="cursor:pointer; background:grey;">
        <li>Awesome!</li>
        <li>Wonderful!</li>
        <li>Try Again!</li>
    </ul>
    <script>
        //document.addEventListener('DOMContentLoaded', () => {
            let commentID = "comment-{{$index}}";
            let commentArea = document.getElementById(commentID);
            let commentList = document.getElementById('commentListID');

            commentArea.addEventListener('focus', function(event) {
                if (commentArea.value == null || commentArea.value == "") {
                    commentList.classList.remove('hidden');
                }
            });
            //commentArea.addEventListener('blur', function(event) {
            //    event.preventDefault();
            //    commentList.classList.add('hidden');
            //});

            commentArea.addEventListener('keyup', function(event) {
                if (this.value == null || this.value == "") {
                    commentList.classList.remove('hidden');
                } else {
                    commentList.classList.add('hidden');
                }
            });

            //let commentLIs = commentList.getElementsByTagName('li');

            //console.log(commentLI);
            //commentLI.
            
            //for (const commentLI of commentLIs) {

                //console.log(commentLI);

            commentList.addEventListener("click", function(event) {
                event.preventDefault();
                //console.log('hello');
                //console.log(this);
                if (event.target.tagName === "LI") {
                    const selectedComment = event.target.textContent;
                    commentArea.value = selectedComment;
                    commentList.classList.add('hidden');
                }
                //commentList.classList.add('hidden');
            });
            //}
        // });
    </script>
@else
    <span>invalid question type</span>
@endif
</flux:fieldset>