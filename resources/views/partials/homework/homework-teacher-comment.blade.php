<section>
    <flux:textarea id="comment-{{$index}}" rows="5" columns="15" />
    <ul class="list-group hidden m-2 p-2" id="commentListID-{{$index}}" style="cursor:pointer; background:grey;">
        <li>Awesome!</li>
        <li>Wonderful!</li>
        <li>Try Again!</li>
    </ul>
    <script>
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
            }
        });

        commentList{{$index}}.addEventListener("click", function(event) {
            event.preventDefault();

            if (event.target.tagName === "LI") {
                const selectedComment = event.target.textContent;
                commentArea{{$index}}.value = selectedComment;
                commentList{{$index}}.classList.add('hidden');
            }
        });
    </script>
</section>