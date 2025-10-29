<section>
    <flux:input id="comment-{{$index}}"  data-rel="g{{$rel}}" />
    <ul class="list-group hidden m-2 p-2" id="commentListID-{{$index}}" style="cursor:pointer; background:grey;">
        <li>Awesome!</li>
        <li>Wonderful!</li>
        <li>Try Again!</li>
        <li>You Can Do It!</li>
    </ul>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        let i = "{{$index}}";
        commentID[i] = "comment-"+i;
        commentListID[i] = "commentListID-"+i;
        commentArea[i] = document.getElementById(commentID[i]);
        commentList[i] = document.getElementById(commentListID[i]);

        commentArea[i].addEventListener('focus', function(event) {
            if (commentArea[i].value == null || commentArea[i].value == "") {
                commentList[i].classList.remove('hidden');
            }
        });
    
        commentArea[i].addEventListener('keyup', function(event) {
            if (this.value == null || this.value == "") {
                commentList[i].classList.remove('hidden');
            } else {
                commentList[i].classList.add('hidden');
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
        commentArea[i].addEventListener('change', function(event) {
            //console.log('yep');
            let rel = this.getAttribute('data-rel');
            let input = document.getElementById(rel);
            //console.log(input);
            console.log(this.value);
            input.value = this.value;
            input.dispatchEvent(new Event('input')); 
        });
*/
        commentList[i].addEventListener("click", function(event) {
            //event.preventDefault();
            if (event.target.tagName === "LI") {
                const selectedComment = event.target.textContent;
                commentArea[i].value = selectedComment;
                commentList[i].classList.add('hidden');
                setVal(commentArea[i]);
            }
        });
    });

    </script>
</section>