function addSubTask(){

    var textBox = document.createElement('input');
    textBox.setAttribute('type', 'text');
    textBox.setAttribute('class', 'subTaskInput');

    var delButton = document.createElement('button');
    delButton.setAttribute('onclick', 'deleteSubTask(this)');
    delButton.setAttribute('class', 'pl-2')

    var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg')
    svg.setAttribute('class', 'h-6 w-6');
    svg.setAttribute('fill', 'none');
    svg.setAttribute('viewBox', '0 0 24 24');
    svg.setAttribute('stroke', 'black');
    svg.setAttribute('stroke-width', '2');

    var path = document.createElementNS("http://www.w3.org/2000/svg", 'path');
    path.setAttribute('stroke-linecap', 'round');
    path.setAttribute('stroke-linejoin', 'round');
    path.setAttribute('d', 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16');
    svg.appendChild(path);

    delButton.appendChild(svg);


    var subTask = document.createElement('li');
    subTask.setAttribute('class', 'p-1');
    subTask.appendChild(textBox);
    subTask.append(delButton);


    if (document.getElementById('subtask-heading') === null){
        var div = document.createElement('div');
        div.setAttribute('class', 'grid grid-cols-1 place-items-center pb-6');
        div.setAttribute('id', 'subtask-input-div');

        var ul = document.createElement('ul');
        ul.setAttribute('id', 'subtask-ul');

        var h3 = document.createElement('h3');
        h3.setAttribute('class', 'text-center text-2xl');
        h3.setAttribute('id', 'subtask-heading');
        var h3node = document.createTextNode('Subtask');
        h3.append(h3node)

        ul.appendChild(subTask);
        div.appendChild(h3);
        div.appendChild(ul);

        let buttondiv = document.getElementById("create-buttons");
        let parentbuttondiv = buttondiv.parentNode;
        parentbuttondiv.insertBefore(div, buttondiv)

    }
    else {
        var div = '';
        var ul = document.getElementById('subtask-ul');
        ul.appendChild(subTask);
    }
}


function subtaskInput (){

}


function deleteSubTask(thisNode){
    thisNode.parentNode.parentNode.removeChild(thisNode.parentNode);
}


function clearTaskInput(){
    var subtaskdiv = document.getElementById("subtask-input-div")
    subtaskdiv.remove();
    //document.getElementById("taskNameInput").value = "";
    //document.getElementById('type').value = 'Personal';
    //document.getElementById('estimatedHoursInput').value = '';
}


function submitTask() {
    var parentDiv = document.getElementById("displayTasks");
    var taskDiv = document.createElement('div');
    taskDiv.setAttribute('class', 'task');
    let taskNumber = document.querySelectorAll('#displayTasks .task').length;
    taskDiv.setAttribute('id', 'task'+taskNumber)

    var br = document.createElement('br')

    let titleNode = document.createTextNode(document.getElementById("taskNameInput").value);
    let typeNode = document.createTextNode(document.getElementById("type").value + ' ');
    let etcNode = document.createTextNode(document.getElementById("estimatedHoursInput").value + ' hours');

    var titleSpan = document.createElement('span');
    titleSpan.setAttribute('class', 'title');
    titleSpan.setAttribute('id', 'title'+taskNumber);
    titleSpan.appendChild(titleNode);

    var typeSpan = document.createElement('span');
    typeSpan.setAttribute('id', 'type'+taskNumber);
    typeSpan.appendChild(typeNode);

    var etcSpan = document.createElement('span');
    etcSpan.setAttribute('id', 'etc'+taskNumber);
    etcSpan.appendChild(etcNode);

    var editButton = document.createElement('button');
    editButton.setAttribute('onclick', 'editFinishedTask()');
    editButton.textContent = 'Edit';

    var delButton = document.createElement('button');
    delButton.setAttribute('onclick', 'deleteFinishedTask()');
    delButton.textContent = 'Delete';

    var ul = document.createElement('ul');

    var subTaskList = document.querySelectorAll(".subTaskInput");
    var subTasks = Array.prototype.slice.call(subTaskList).map(function (element) {
        return element.value;
    });

    for (let i = 0; i < subTasks.length; i++) {
        var li = document.createElement('li');
        li.setAttribute('id', 'task'+taskNumber+'-subtask'+(i+1));
        var liNode = document.createTextNode(subTasks[i]);
        li.appendChild(liNode);
        ul.appendChild(li);
    }

    taskDiv.appendChild(titleSpan);
    taskDiv.appendChild(br);
    taskDiv.appendChild(typeSpan);
    taskDiv.appendChild(etcSpan);
    taskDiv.appendChild(editButton);
    taskDiv.appendChild(delButton);
    taskDiv.appendChild(ul);

    parentDiv.appendChild(taskDiv);

    clearTaskInput();
}


function applysvg(){


}
