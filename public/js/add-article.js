'use strict';

let addForm = document.forms['add-article'];

addForm.addEventListener('submit', async (event)=>{
    event.preventDefault();
    const response = await fetch(addForm.action,
        {
            method: addForm.method,
            body: new FormData(addForm)
        });
    const answer = await response.json();
    console.log(answer);
});