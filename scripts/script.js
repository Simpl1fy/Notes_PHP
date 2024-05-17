

edits = document.getElementsByClassName('edit');
Array.from(edits).forEach((element) => {
    element.addEventListener("click", (e) => {
        tr = e.target.parentNode.parentNode
        title = tr.getElementsByTagName('td')[0].innerText;
        description = tr.getElementsByTagName('td')[1].innerText;
        titleEdit.value = title;
        descEdit.value = description;
        uidEdit.value = e.target.id;
        console.log(e.target.id);
    });
});