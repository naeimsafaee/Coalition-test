var dragSrcEl = null;

function handleDragStart(e) {
    dragSrcEl = this;

    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/html', this.outerHTML);

    this.classList.add('dragElem');
}

function handleDragOver(e) {
    if (e.preventDefault) {
        e.preventDefault();
    }
    this.classList.add('over');

    e.dataTransfer.dropEffect = 'move';

    return false;
}

function handleDragEnter(e) {
}

function handleDragLeave(e) {
    this.classList.remove('over');
}

function handleDrop(e) {

    if (e.stopPropagation) {
        e.stopPropagation();
    }

    if (dragSrcEl != this) {

        this.parentNode.removeChild(dragSrcEl);
        var dropHTML = e.dataTransfer.getData('text/html');
        this.insertAdjacentHTML('beforebegin', dropHTML);
        var dropElem = this.previousSibling;
        addDnDHandlers(dropElem);

    }
    this.classList.remove('over');
    return false;
}

function renameTags(){
    $('.items').map(function (index) {
        $(this).find('span').text(`#${index + 1}`)
    });
}

function handleDragEnd(e) {

    const taskIdArray = $('.items').map(function (index) {
        return {
            task_id: parseInt($(this).data('task_id')),
            index: index + 1
        };
    }).get();

    $.ajax({
        type: 'POST',
        url: '/api/task/reorder',
        data: {
            order: taskIdArray
        },
        success: function (response) {
            console.log('Data sent successfully!');
            console.log(response);

            renameTags()
        },
        error: function (error) {
            console.error('Error while sending data:', error);
        }
    });

    this.classList.remove('over');
}

function addDnDHandlers(elem) {
    elem.addEventListener('dragstart', handleDragStart, false);
    elem.addEventListener('dragenter', handleDragEnter, false)
    elem.addEventListener('dragover', handleDragOver, false);
    elem.addEventListener('dragleave', handleDragLeave, false);
    elem.addEventListener('drop', handleDrop, false);
    elem.addEventListener('dragend', handleDragEnd, false);

}

var cols = document.querySelectorAll('#columns .column');
[].forEach.call(cols, addDnDHandlers);