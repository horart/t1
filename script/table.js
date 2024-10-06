document.addEventListener('DOMContentLoaded', function() {
    let flag = false;
    document.querySelectorAll('.filter').forEach(e => {
        e.querySelector('button').addEventListener('click', function() {
            e.querySelector('.checkboxes').classList.toggle('hidden');
            flag = true;
        });
    });
    document.body.addEventListener('click', function(e) {
        if(flag) {
            flag = false;
            return;
        }
        if(!e.target.closest('.checkboxes')) {
            document.querySelectorAll('.checkboxes').forEach(el => el.classList.add('hidden'));
        }
    });
    document.querySelectorAll('.thead').forEach(e => e.addEventListener('click', function () {
        if(e.classList.contains('up')) {
            e.classList.replace('up', 'down');
        }
        else if(e.classList.contains('down')) { // sorts
            e.classList.remove('down');
        }
        else {
            e.classList.add('up');
        }
        document.querySelectorAll('.thead').forEach(el => { if(el != e) el.classList.remove('up', 'down') });
    }));
    let editing = false;
    document.querySelectorAll('.table .editable').forEach(e => {
        if(e.querySelectorAll('.edit-cell')) {
            e.querySelector('.edit-cell').classList.add('hidden');// CHANGE
            e.addEventListener('dblclick', function() {
                // add link support
                if(!editing) {
                    e.querySelector('.edit-cell').value = e.querySelector('span').textContent;
                    e.querySelector('.edit-cell').classList.toggle('hidden');
                    e.querySelector('span').textContent = '';
                    e.querySelector('.edit-cell').focus();
                    editing = true;
                }
            });
            e.querySelector('.edit-cell').addEventListener('blur', function() {
                e.querySelector('.edit-cell').classList.toggle('hidden');
                e.querySelector('span').textContent = e.querySelector('.edit-cell').value;
                editing = false;
            });
        }
    });
    document.querySelectorAll('.thead', function(e) {
        if(e.hasAttribute('.thead')) {
            
        }
    });
});