function insertWordBlock(container, sortwords, wordorders) {
    console.log('hitting insert word block');
    if (!container || !sortwords || !wordorders || wordorders.length === 0) {
        console.log('not running insertwordblock');
        console.log(container);
        console.log(sortwords);
        console.log(wordorders);
        return;
    }
    // handling for match, the variable should be a object array containing one word string
    if (typeof wordorders === 'string') {
        wordorders = Array.from({ length: 1 }, (_, i) => ((wordorders)));
    }
    console.log('ready to sort by wordorders:'+wordorders.join(','));
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
        console.log(container_id);
        console.log(sortwords);
        console.log(wordorders);

        const notwordorders = allwordorders.filter(elem => !wordorders.includes(elem));
        
        // handling for type='sort'
        if (!to_container_id) {
            wordorders = wordorders.length > 0 ? wordorders : notwordorders;
            insertWordBlock(container, sortwords, wordorders);
        // handling for 'match' & 'drop'
        } else {
            const to_container = document.getElementById(to_container_id);
            if (!to_container) {
                console.warn('To Container not found by id:'+to_container_id);
                return;
            }
            insertWordBlock(container, sortwords, notwordorders);

            if (to_container.classList.contains('list-group')) {
                insertWordBlock(to_container, sortwords, wordorders);
            } else if (to_container.classList.contains('list-parent-group')) {
                const to_containers = [...to_container.getElementsByClassName('list-group')];
                if (!to_containers || to_containers.length == 0) {
                    console.log('cannot find to containers');
                    return;
                }
                to_containers.forEach((to_each_container, i) => {
                    insertWordBlock(to_each_container, sortwords, wordorders[i]);
                });
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
            console.log('cannot find sort group');
            return;
        } else {
            console.log('found sort group');
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
                return to.el.children.length <= 1;
            }
            // Add swap plugin configuration
            settings.swap = true; // Enable swap
            settings.swapClass = 'sortable-swap-highlight'; // CSS class for swap indication
            settings.swapThreshold = 1; //
        }

        new Sortable(el, settings);
    });
}
