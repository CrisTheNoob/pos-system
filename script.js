document.getElementById("menu-toggle").addEventListener("click", function() {
    document.getElementById("wrapper").classList.toggle("toggled");
});

document.getElementById('barcodeSearchForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent normal form submission

    // Get the form data
    const formData = new FormData(this);

    // Send the request to the server
    fetch('search.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Insert the search results into the modal
        document.getElementById('searchResults').innerHTML = data;
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('searchResults').innerHTML = '<p class="text-danger">An error occurred while processing your request.</p>';
    });
});
