<section>
    <h3>hello do lesson {{$lesson->title}}</h3>
    <!-- Modal toggle
    <button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    Toggle modal
    </button>
    -->
    <!-- Main modal -->
    <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="overflow-y-auto overflow-x-hidden top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full pt-4 max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        <label id="question-text">Question 1</label>
                    </h3>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    <div id="answer-div">Answer</div> 
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="static-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button>
                    <button data-modal-hide="static-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden">
        <form method="POST" wire:submit="store">
        @foreach (@$lessonmodules as $key => $lessonmodule)
            <input
                id="a{{$key}}"
                wire:model="form.answer.{{$key}}"
                data-question="{{ $lessonmodule->question }}"
                data-type="{{ $lessonmodule->type }}"
                type="text"
                placeholder="your answer"
            />
        @endforeach
        </form>
    </div>
</section>

<script>

    let counter = 1;

    document.addEventListener('DOMContentLoaded', function() {
    // Your JavaScript code to execute after the DOM is ready
        console.log('DOM is fully loaded and parsed!');

        let inputElement = document.querySelector('#a'+counter);
        let questionText = document.querySelector('#question-text');
        let answerDiv = document.querySelector('#answer-div');

        console.log(inputElement.getAttribute('data-type'));

        if (inputElement.getAttribute('data-type') == 'fill-in-blank') {
            questionText.innerText = '請填寫空格';
            answerDiv.innerHTML = inputElement.getAttribute('data-question');
        }

        // Example: Manipulate an element
        // document.getElementById('myElement').textContent = 'Content changed!';
    });
</script>
