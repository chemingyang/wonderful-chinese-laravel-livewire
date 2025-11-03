function insertWordBlocks(question, answer, idx) {
    const container = document.getElementById(idx);
    if (!container) {
        console.warn('Container not found by id:'+idx);
        return;
    }

    try {
        const wordorders = answer ? answer.split(',') : [];
        const sortwords = question ? question.split('|') : [];
        if (sortwords.length === 1) throw new Error('words not split by pipe symbol');
    
        // Create ordered array of nodes based on wordorders
        const nodes = sortwords.map((word, i) => {
            const orderIndex = wordorders.indexOf(String(i + 1)) ?? i;
            const position = orderIndex === -1 ? -1 : orderIndex;
            
            return {
                position: position,
                element: createListGroupItem(i + 1, word)
            };
        });
        // Sort by position and append elements
        let elements = [];
        nodes
            .sort((a, b) => a.position - b.position)
            .forEach(node => {if (node.position >= 0) elements.push(node.element)});
        container.replaceChildren(...elements);
    } catch (error) {
        console.error('Error inserting word blocks:', error);
    }
}
function createListGroupItem(index, word) {
    // Create main div
    const div = document.createElement('div');
    div.setAttribute('data-val', index);
    div.className = 'list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800';
    div.style.zIndex = '1';
    div.style.opacity = '75%';

    // Create span
    const span = document.createElement('span');
    span.textContent = `${index}. ${word}`;

    // Append span to div
    div.appendChild(span);

    return div;
}
function makeSortable(elemIDArr, idx) {
    elemIDArr.forEach(function(elemID, i) {
        let el = document.getElementById(elemID);
        new Sortable(el, {
            animation: 150,
            group: {
                name: 'shared'
            },
            onEnd: function (evt) { 
                const parent = document.getElementById(elemIDArr[0]);
                const childs = parent.getElementsByTagName('div');
                // let idx = "{{$idx}}";
                let vals = [];
                for (const child of childs) {
                    vals.push(child.getAttribute('data-val'));
                }
                const inputElemID = 'a'+idx;
                //console.log(inputElemID);
                let inputElem = document.getElementById(inputElemID);
                //console.log(inputElem);
                inputElem.value = vals.join(',');
                inputElem.dispatchEvent(new Event('input')); 
            },
            ghostClass: 'blue-background-class'
        });
    });
}
