<section>
    <flux:textarea id="comment-{{$index}}"  data-rel="g{{$rel}}" rows="5" columns="15" />
    <ul class="list-group hidden m-2 p-2" id="commentListID-{{$index}}" style="cursor:pointer; background:grey;">
        <li>Awesome!</li>
        <li>Wonderful!</li>
        <li>Try Again!</li>
        <li>You Can Do It!</li>
    </ul>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        let commentID{{$index}} = "comment-{{$index}}";
        let commentListID{{$index}} = "commentListID-{{$index}}";
        let commentArea{{$index}} = document.getElementById(commentID{{$index}});
        let commentList{{$index}} = document.getElementById(commentListID{{$index}});

        commentArea{{$index}}.addEventListener('focus', function(event) {
            if (commentArea{{$index}}.value == null || commentArea{{$index}}.value == "") {
                commentList{{$index}}.classList.remove('hidden');
            }
        });
    
        commentArea{{$index}}.addEventListener('keyup', function(event) {
            if (this.value == null || this.value == "") {
                commentList{{$index}}.classList.remove('hidden');
            } else {
                commentList{{$index}}.classList.add('hidden');
                setVal(this);
            }
        });

        function setVal(obj) {
            let rel = obj.getAttribute('data-rel');
            let input = document.getElementById(rel);
            input.value = obj.value;
            input.dispatchEvent(new Event('input'));
        }
/*
        commentArea{{$index}}.addEventListener('change', function(event) {
            //console.log('yep');
            let rel = this.getAttribute('data-rel');
            let input = document.getElementById(rel);
            //console.log(input);
            console.log(this.value);
            input.value = this.value;
            input.dispatchEvent(new Event('input')); 
        });
*/
        commentList{{$index}}.addEventListener("click", function(event) {
            //event.preventDefault();
            if (event.target.tagName === "LI") {
                const selectedComment = event.target.textContent;
                commentArea{{$index}}.value = selectedComment;
                commentList{{$index}}.classList.add('hidden');
                setVal(commentArea{{$index}});
            }
        });
    });

    </script>
</section>