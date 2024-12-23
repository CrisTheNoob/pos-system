document.getElementById("menu-toggle").addEventListener("click", function() {
    document.getElementById("wrapper").classList.toggle("toggled");
});

document.getElementById('barcodeSearchForm').addEventListener('submit', function(e) {
    e.preventDefault(); 

    
    const formData = new FormData(this);

    
    fetch('search.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        
        document.getElementById('searchResults').innerHTML = data;
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('searchResults').innerHTML = '<p class="text-danger">An error occurred while processing your request.</p>';
    });
});
