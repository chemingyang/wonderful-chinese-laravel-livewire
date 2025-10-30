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

        if (matched) {
            commentArea[i].value = commentList[i].querySelectorAll('li')[0].innerText;
            setFormVal(commentArea[i]);
        }

        commentArea[i].addEventListener('focus', function(event) {
            const lists = document.getElementsByClassName('commentList');
            for (const list of lists) {
                list.classList.add('hidden');
            }
            commentList[i].classList.remove('hidden');
        });

        /* cannot seem to get this to work properly*/
        /* teacher forced to select one or type something */
        commentDiv[i].addEventListener('blur', function(event) {
            //console.log('blur...');
            //if (commentArea[i].value == null || commentArea[i].value == "") {
            commentList[i].classList.add('hidden');
            //}
        });

        commentArea[i].addEventListener('keyup', function(event) {
            if (/^([\\x30-\\x39]|[\\x61-\\x7a])$/i.test(event.key)) {
                //console.log('char key');
                commentList[i].classList.add('hidden');
                setFormVal(this);
            } else {
                //console.log('non char');
                if (this.value == null || this.value == "") {
                    commentList[i].classList.remove('hidden');
                }
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
            if (event.target.tagName === "LI") {
                const selectedComment = event.target.textContent;
                commentArea[i].value = selectedComment;
                commentList[i].classList.add('hidden');
                setFormVal(commentArea[i]);
            }
        });
    });
</script>