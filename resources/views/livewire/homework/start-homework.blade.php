<section>
    <div id="static-modal" data-modal-backdrop="static" tabindex="-1" class="overflow-y-auto overflow-x-hidden top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full pt-4 max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        <span id="question-text">Question 1</span>
                    </h3>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    <div id="answer-div">Answer</div> 
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button id="next-button", type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 justify-right">Next</button>
                    <div>
                        <form method="POST" wire:submit="store">
                            @foreach (@$lessonmodules as $key => $lessonmodule)
                                <flux:input
                                    class="answers hidden"
                                    id="a{{$key}}"
                                    wire:model="form.answers.{{$lessonmodule->id}}"
                                    data-question="{{ $lessonmodule->question }}"
                                    data-type="{{ $lessonmodule->type }}"
                                    data-id="{{$lessonmodule->id}}"
                                    type="text"
                                    placeholder="your answer"
                                />
                            @endforeach
                            <flux:input class="hidden" id="student-id" type="text" wire:model="form.student_id" placeholder="student id" />
                            <flux:input class="hidden" id="lesson-id" type="text" wire:model="form.lesson_id" placeholder="lesson id"/>
                            <button id="submit-button" type="submit" class="hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-md px-8 py-4 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit Homework</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    let counter = 1;
    const studentID = "{{ @$student_id }}";
    const lessonID = "{{ @$lesson->id }}";
    const questionText = document.getElementById('question-text');
    const answerDiv = document.getElementById('answer-div');
    const nextButton = document.getElementById('next-button');
    const maxCount = document.querySelectorAll('.answers').length;
    const submitButton = document.getElementById('submit-button');
   
    function initSort(elemIDArr) {
        elemIDArr.forEach(function(elemID, index) {
            let el = document.getElementById(elemID);
            new Sortable(el, {
                animation: 150,
                group: {
                    name: 'shared'
                },
                ghostClass: 'blue-background-class'
            });
        });
    }

    function doNextStep(count) {
        
        let curr = count - 1;
        let prev = curr - 1;

        if (prev >= 0) {
            let hiddenElement = document.getElementById('a'+prev);
            let prevElements = document.querySelectorAll('[data-rel="a'+prev+'"]');

            if (prevElements.length > 0 && hiddenElement !== null) {
                let inputVals = Array.from(prevElements).map(element => (element.value ?? element.getAttribute('data-val')));
                hiddenElement.value = inputVals.toString();
                // console.log('set #a'+prev+' value to '+inputVals.toString());
                hiddenElement.dispatchEvent(new Event('input'));
            } else {
                // console.log('cannot set hidden input field. abort.');
                return;
            }
            // console.log('element '+prev+' value '+hiddenElement.value);
            //@this.set('answers.'+prev, inputVals.toString());
        } else {
            // console.log('skipping set prev input');
        }

        if (count <= maxCount) {
            let inputElement = document.getElementById('a'+curr);

            if (inputElement !== null ) {
                let elemDataType = inputElement.getAttribute('data-type');

                if (elemDataType === 'fill-in-blank') {
                    questionText.innerText = 'Q'+count+'. 請填寫空格:';
                    answerDiv.innerHTML = inputElement.getAttribute('data-question').replaceAll('<>','<input type="text" class="inline border-1 border-color:#fff" style="width:50px; padding:5px; margin: 5px" name="a'+curr+'" data-rel="a'+curr+'" />',);
                } else if (elemDataType === 'answer-question') {
                    questionText.innerText = 'Q'+count+'. '+inputElement.getAttribute('data-question');
                    answerDiv.innerHTML = '<input type="textarea" rows="4" columns="25" class="inline border-1 border-color:#fff" padding:5px; margin: 5px" data-rel="a'+curr+'" />';
                } else if (elemDataType === 'sort') {
                    let dataQuestion = inputElement.getAttribute('data-question');
                    let dataID = inputElement.getAttribute('data-id');
                    let wordsArr = dataQuestion.split("|");
                    let inner = '<div id="sort'+dataID+'" class="flex list-group">';
                    wordsArr.forEach(function(word, index) {
                        inner += '<div data-val="'+(index+1)+'" data-rel="a'+curr+'" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span>'+word+'</span></div>';
                    });
                    inner += '</div>';
                    questionText.innerText = 'Q'+count+'. 請排序下列的字格:';
                    answerDiv.innerHTML = inner;
                    initSort(['sort'+dataID]);
                } else if (elemDataType === 'drop') {
                    let dataQuestion = inputElement.getAttribute('data-question');
                    let dataID = inputElement.getAttribute('data-id');
                    let tmpArr = dataQuestion.split(":");
                    let wordsArr = tmpArr[1].split("|");
                    let inner = '<div class="grid w-full gap-6 md:grid-cols-2"><div id="sort'+dataID+'-left" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 justify-left">';
                    wordsArr.forEach(function(word, index) {
                        inner += '<div data-val="'+(index+1)+'" data-rel="a'+curr+'" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span>'+word+'</span></div>';
                    });
                    inner += '</div><div><label>Family</label><div id="sort'+dataID+'-right" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 justify-right"><label>&nbsp;</label></div><div></div>';
                    questionText.innerText = 'Q'+count+'.'+tmpArr[0];
                    answerDiv.innerHTML = inner;
                    initSort(['sort'+dataID+'-left','sort'+dataID+'-right']);
                } else if (elemDataType === 'match') {
                    let dataQuestion = inputElement.getAttribute('data-question');
                    // console.log(dataQuestion)
                    let dataID = inputElement.getAttribute('data-id');
                    let tmpArr = dataQuestion.split(":");
                    // console.log(tmpArr);
                    let wordsArr = tmpArr[0].split("|");
                    let boxesArr = tmpArr[1].split("|");
                    let inner = '<div class="grid w-full gap-6 md:grid-cols-2"><div id="sort'+dataID+'-left" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 justify-left">';
                    wordsArr.forEach(function(word, index) {
                        inner += '<div data-val="'+(index+1)+'" data-rel="a'+curr+'" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span>'+word+'</span></div>';
                    });
                    inner += '</div><div class="flex justify-right">';
                    boxesArr.forEach(function(box, index) {
                        inner += '<div><label>'+box+'</label><div id="sort'+dataID+'-right-'+index+'" data-val="'+(index+1)+'" data-rel="b'+curr+'" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1"><label>&nbsp;</label></div></div>';
                    });
                    inner += '</div></div>';
                    questionText.innerText = 'please match words to boxes.';
                    answerDiv.innerHTML = inner;
                    initSort(['sort'+dataID+'-left','sort'+dataID+'-right-0','sort'+dataID+'-right-1','sort'+dataID+'-right-2']);
                } else {
                    // console.log('unknown or unable to get lesson module type. abort');
                    return;
                }
            } else {
                // console.log('input element with #a'+curr+" returned null.");
                return;
            }
        } else {
            let inputStudentID = document.getElementById('student-id');
            let inputLessonID = document.getElementById('lesson-id');
            if (inputStudentID !== null && inputLessonID !== null) {
                inputStudentID.value = studentID;
                inputStudentID.dispatchEvent(new Event('input'));
                inputLessonID.value = lessonID;
                inputLessonID.dispatchEvent(new Event('input'));
                // console.log('set student and lesson id');
            } else {
                // console.log('cannot set student and lesson id');
                return;
            }
            questionText.innerText = "You have reached the end. Ready to Submit?"
            answerDiv.innerHTML = '';
            nextButton.classList.add('hidden');
            submitButton.classList.remove('hidden');
        }
        // if we haven't reach the question question do next
        // otherwise hide the question and show the submit button        
    }

    nextButton.addEventListener('click', function() {
        counter++;
        doNextStep(counter);
    });

    document.addEventListener('DOMContentLoaded', () => {
        // console.log('DOM is loaded! livewire initialized');
        doNextStep(counter);
    });
</script>