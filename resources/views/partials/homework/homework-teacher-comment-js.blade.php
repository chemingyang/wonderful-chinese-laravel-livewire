<script>
    document.addEventListener('DOMContentLoaded', () => {
        const i = "{{$index}}";
        const matched = false;
        commentID[i] = "comment-"+i;
        commentListID[i] = "commentList-"+i;
        commentArea[i] = document.getElementById(commentID[i]);
        commentList[i] = document.getElementById(commentListID[i]);

        if (matched) {
            //console.log(commentList[i].querySelectorAll('li'));
            commentArea[i].value = commentList[i].querySelectorAll('li')[0].innerText;
        }

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
                setVal(commentArea[i]);
            }
        });
    });
</script>