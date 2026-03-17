// This file contains JavaScript code for client-side functionality, such as form validation and AJAX requests.

document.addEventListener('DOMContentLoaded', function() {
    // Example of form validation for create and edit forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            let isValid = true;
            const inputs = form.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                if (input.value.trim() === '') {
                    isValid = false;
                    input.classList.add('error');
                } else {
                    input.classList.remove('error');
                }
            });
            if (!isValid) {
                event.preventDefault();
                alert('Please fill in all fields.');
            }
        });
    });

    // Example of AJAX request for deleting a record
    const deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            const recordId = this.dataset.id;
            if (confirm('Are you sure you want to delete this record?')) {
                fetch(`delete.php?id=${recordId}`, {
                    method: 'DELETE'
                })
                .then(response => {
                    if (response.ok) {
                        alert('Record deleted successfully.');
                        location.reload();
                    } else {
                        alert('Error deleting record.');
                    }
                });
            }
        });
    });
});