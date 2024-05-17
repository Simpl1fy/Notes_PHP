

edits = document.getElementsByClassName('edit');
Array.from(edits).forEach((element) => {
    element.addEventListener("click", (e) => {
        console.log('edit was pressed');
        tr = e.target.parentNode.parentNode
        title = tr.getElementsByTagName('td')[0].innerText;
        description = tr.getElementsByTagName('td')[1].innerText;
        console.log("Title is = ", title, "Description is ", description);
        titleEdit.value = title;
        descEdit.value = description;
    });
});