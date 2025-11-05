function insertTextInput(words, idx) {
    const container_id = 'q'+idx;
    const container = document.getElementById(container_id);
    if (!container) {
        console.warn('Container not found by id:'+container_id);
        return;
    }
    const childs = [...container.getElementsByClassName('data-target')];
    if (!childs) {
        console.warn('input elements in container not found.'+childs);
        return;
    }
    childs.forEach((child, i) => {
        child.value = words[i] ?? '';
    });
}

function handleTextInput(idx) {
    //console.log('hitting fill in blank-(x) or answer question');
    const container_id = 'q'+idx;
    const container = document.getElementById(container_id);
    if (!container) {
        console.warn('Container not found by id:'+container_id);
        return;
    }
    // console.log(data_rel);
    container.addEventListener('keyup', function(event) {
        //console.log('in f-i-b keyup');
        const childs = [...this.getElementsByClassName('data-target')];
        if (!childs) {
            console.warn('input elements in container not found.'+childs);
            return;
        }
        let vals = [];
        childs.forEach(child => {
            vals.push(child.value);
        }) 
        //console.log(vals);
        const inputElemID = 'a'+idx
        let inputElem = document.getElementById(inputElemID);
        if (!inputElem) {
            console.warn('input elem not found by id:'+inputElemID);
            return;
        }
        inputElem.value = vals.join(',');
        inputElem.dispatchEvent(new Event('input'));
    }); 
}

function insertWordBlock(container, sortwords, wordorders) {
    if (!wordorders || wordorders.length === 0) {
        return;
    }
    if (!container || !sortwords) {
        console.warn('container or sortwords not found');
        return;
    }
    // handling for match, the variable should be a object array containing one word string
    if (typeof wordorders === 'string') {
        wordorders = Array.from({ length: 1 }, (_, i) => ((wordorders)));
    }
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
}

function insertWordBlocks(sortwords, wordorders, container_id, to_container_id = null) {
    const container = document.getElementById(container_id);
    if (!container) {
        console.warn('Container not found by id:'+container_id);
        return;
    }

    try {
        //const wordorders = answer ? answer.split(',') : [];
        //const sortwords = question ? question.split('|') : [];
        //if (sortwords.length <= 1) throw new Error('need more than 1 word.');
        //if (wordorders.length == 0 && container_id.indexOf('left') > -1) {
            // generate {'1','2','3',..'n'} object array matching sortwords' length
        const allwordorders = Array.from({ length: sortwords.length }, (_, i) => (( i + 1 ).toString()));
        //}
        const notwordorders = allwordorders.filter(elem => !wordorders.includes(elem));
        
        if (!to_container_id) { // handling for type='sort'
            wordorders = wordorders.length > 0 ? wordorders : notwordorders;
            insertWordBlock(container, sortwords, wordorders);
        } else { // handling for 'match' & 'drop'
            insertWordBlock(container, sortwords, notwordorders);
            const to_container = document.getElementById(to_container_id);
            if (!to_container) {
                console.warn('To Container not found by id:'+to_container_id);
                return;
            }
            if (to_container.classList.contains('list-group')) {
                insertWordBlock(to_container, sortwords, wordorders);
            } else if (to_container.classList.contains('list-parent-group')) {
                const to_containers = [...to_container.getElementsByClassName('list-group')];
                if (!to_containers || to_containers.length == 0) {
                    console.warn('cannot find to containers');
                    return;
                }
                to_containers.forEach((to_each_container, i) => {
                    insertWordBlock(to_each_container, sortwords, wordorders[i]);
                });
            } else {
                console.warn('cannot find destination to_container(s)');
            }
        }
    } catch (error) {
        console.error('Error inserting word blocks:', error);
    }
}
function createListGroupItem(index, word) {
    // Create main div
    const div = document.createElement('div');
    div.setAttribute('data-val', index);
    div.className = 'list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-1 py-1 m-1 min-w-3 w-full item-center justify-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800';
    div.style.zIndex = '1';
    div.style.opacity = '75%';
    // Create span
    const span = document.createElement('span');
    span.textContent = `${index}. ${word}`;
    span.className = 'flex px-2 py-1 text-center justify-center';
    // Append span to div
    div.appendChild(span);

    return div;
}

function getValsFromChildren(parent, notempty = false) {
    let vals = [];
    const childs = [...parent.getElementsByClassName('list-group-item')];
    childs.forEach((child, _) => {
        vals.push(child.getAttribute('data-val'));
    });
    // special handling for type==='match' each empty matchbox return 0 to keep its place in answer
    if (notempty && vals.length === 0) {
        vals.push("0");
    }
    return vals;
}

function makeSortable(elemIDArr, idx, parent_id, swap=false) {
    // consider maing elemIDArr not an array a check
    if (elemIDArr.length === 0) {
        console.log('humm no item group found.');
    }

    elemIDArr.forEach(function(elemID, i) {
        let el = document.getElementById(elemID);
        if (!el) {
            console.warn('cannot find sort group');
            return;
        }

        let settings = {
            animation: 150,
            group: {
                name: 'shared'
            },
            onEnd: function (evt) {
                // console.log('hitting onend');
                const parent = document.getElementById(parent_id);
                if (!parent) {
                    console.log('cannot find parent/grandparent container by'+parent_id);
                    return;
                }
                let vals = [];
                // handling for match
                if (!parent.classList.contains('list-group')) {
                    const parents = [...parent.getElementsByClassName('list-group')];
                    parents.forEach((each_parent, i) => {
                        vals.push(...getValsFromChildren(each_parent, true));
                    });
                } else {
                    vals.push(...getValsFromChildren(parent));
                }
                let inputElem = document.getElementById('a'+idx);
                inputElem.value = vals.join(',');
                inputElem.dispatchEvent(new Event('input'));
            },
            ghostClass: 'blue-background-class'
        };

        if (swap) {
            settings.group.put = function (to, from, dragEl, evt) {
                if (to.el.children.length > 0 && from.options.swap && to.options.swap) {
                    return true;
                }
                // Otherwise only allow dropping if container is empty
                return to.el.children.length < 1;
            }
            // Add swap plugin configuration
            settings.swap = true; // Enable swap
            settings.swapClass = 'sortable-swap-highlight'; // CSS class for swap indication
            settings.swapThreshold = 0.75; //
        }
        new Sortable(el, settings);
    });
}