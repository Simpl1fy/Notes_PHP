

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


deletes = document.getElementsByClassName('delete');
Array.from(deletes).forEach((element) => {
    element.addEventListener("click", (e) => {
        console.log("Delete is pressed");
        uid = e.target.id.substr(1,);
        console.log(uid);
        if(confirm("Are you sure you want to delete this note?")) {
            console.log('Yes');
            window.location = `/Note-Taker/index.php?delete=${uid}`;
        } else {
            console.log('No');
        }
    });
});