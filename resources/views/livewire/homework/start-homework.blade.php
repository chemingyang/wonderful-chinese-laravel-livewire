<section>
    <!-- Modal toggle
    <button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    Toggle modal
    </button>
    -->
    <!-- Main modal -->
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
    const studentID = {{ @$student_id }};
    const lessonID = {{ @$lesson->id }};
    const questionText = document.querySelector('#question-text');
    const answerDiv = document.querySelector('#answer-div');
    const nextButton = document.querySelector('#next-button');
    const maxCount = document.querySelectorAll('.answers').length;
    const submitButton = document.querySelector('#submit-button');
   

    function doNextStep(count) {
        
        let curr = count - 1;
        let prev = curr - 1;

        if (prev >= 0) {
            let prevElements = document.querySelectorAll('[data-rel="a'+prev+'"]');
            let inputDataID = document.querySelector('#a'+prev).getAttribute('data-id');
            let inputVals = Array.from(prevElements).map(element => element.value);
            let hiddenElement = document.querySelector('#a'+prev);
            // let hiddenElement = Livewire.find('a0');
            //console.log(hiddenElement);
            //hiddenElement.set('form.answers.'+inputDataID, inputVals.toString());
            hiddenElement.value = inputVals.toString();
            hiddenElement.dispatchEvent(new Event('input'));
            //console.log('element '+prev+' value '+hiddenElement.value);
            //@this.set('answers.'+prev, inputVals.toString());
        }

        if (count <= maxCount) {
            let inputElement = document.querySelector('#a'+curr);
            if (inputElement.getAttribute('data-type') == 'fill-in-blank') {
                questionText.innerText = 'Q'+count+'. 請填寫空格:';
                answerDiv.innerHTML = inputElement.getAttribute('data-question').replaceAll('<>','<input type="text" class="inline border-1 border-color:#fff" style="width:50px; padding:5px; margin: 5px" name="a'+curr+'" data-rel="a'+curr+'" />',);
            } else if (inputElement.getAttribute('data-type') == 'answer-question') {
                questionText.innerText = 'Q'+count+'. '+inputElement.getAttribute('data-question');
                answerDiv.innerHTML = '<input type="textarea" rows="4" columns="25" class="inline border-1 border-color:#fff" padding:5px; margin: 5px" data-rel="a'+curr+'" />';
            } // elseif (inputElement.getAttribute('data-type') == 'sort') {
        } else {
            questionText.innerText = "You have reached the end. Ready to Submit?"
            answerDiv.innerHTML = '';
            nextButton.classList.add('hidden');
            submitButton.classList.remove('hidden');
            let inputStudentID = document.querySelector('#student-id');
            let inputLessonID = document.querySelector('#lesson-id');
            //Livewire.find().set('student_id',studentID);
            //Livewire.find().set('lesson_id',lessonID);
            inputStudentID.value = studentID;
            inputStudentID.dispatchEvent(new Event('input'));
            inputLessonID.value = lessonID;
            inputLessonID.dispatchEvent(new Event('input'));

        }
        // if we haven't reach the question question do next
        // otherwise hide the question and show the submit button        
    }

    nextButton.addEventListener('click', function() {
        counter++;
        doNextStep(counter);
    });

    document.addEventListener('livewire:initialized', () => {
    // Your JavaScript code to execute after the DOM is ready
        console.log('DOM is loaded! livewire initialized');
         
        doNextStep(counter);
        // Example: Manipulate an element
        // document.getElementById('myElement').textContent = 'Content changed!';
    });
</script>