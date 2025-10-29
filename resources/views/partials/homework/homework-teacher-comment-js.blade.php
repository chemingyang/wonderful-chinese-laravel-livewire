<script>
    document.addEventListener('DOMContentLoaded', () => {
        const i = "{{$index}}";
        const matched = @json($matched);
        commentID[i] = "comment-"+i;
        commentListID[i] = "commentList-"+i;
        commentDivID[i] = "commentDiv-"+i;
        commentArea[i] = document.getElementById(commentID[i]);
        commentList[i] = document.getElementById(commentListID[i]);
        commentDiv[i] = document.getElementById(commentDivID[i]);

        //console.log(matched);
        if (matched) {
            //console.log(commentList[i].querySelectorAll('li'));
            commentArea[i].value = commentList[i].querySelectorAll('li')[0].innerText;
            setFormVal(commentArea[i]);
        }

        commentArea[i].addEventListener('focus', function(event) {
            //if (commentArea[i].value == null || commentArea[i].value == "") {
            commentList[i].classList.remove('hidden');
            //}
        });

        /* cannot seem to get this to work properly*/
        /* teacher forced to select one or type something */
        commentList[i].addEventListener('blur', function(event) {
            console.log('blur...');
            //if (commentArea[i].value == null || commentArea[i].value == "") {
            commentList[i].classList.add('hidden');
            //}
        });

        commentArea[i].addEventListener('keyup', function(event) {
            if (this.value == null || this.value == "") {
                commentList[i].classList.remove('hidden');
            } else {
                commentList[i].classList.add('hidden');
                setFormVal(this);
            }
        });

        function setFormVal(obj) {
            const rel = obj.getAttribute('data-rel');
            if (rel != null) {
                let input = document.getElementById(rel);
                input.value = obj.value;
                input.dispatchEvent(new Event('input'));
            }
        }

        commentList[i].addEventListener("click", function(event) {
            //event.preventDefault();
            if (event.target.tagName === "LI") {
                const selectedComment = event.target.textContent;
                commentArea[i].value = selectedComment;
                commentList[i].classList.add('hidden');
                setFormVal(commentArea[i]);
            }
        });
    });
</script>