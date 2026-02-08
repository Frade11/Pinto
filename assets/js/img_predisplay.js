const fileInput = document.querySelector('input[name="media_file"]');
const preview = document.getElementById('file-preview');

fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    if(file){
        // Показываем имя файла
        preview.innerHTML = `<strong>Selected file:</strong> ${file.name}<br>`;

        // Добавляем мини-превью
        if(file.type.startsWith('image/')){
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.maxWidth = '200px';
            img.style.marginTop = '10px';
            preview.appendChild(img);
        }
    } else {
        preview.innerHTML = ''; 
    }
});

// Валидация формы перед отправкой
document.querySelector('form').addEventListener('submit', function(e) {
    const categorySelect = this.querySelector('select[name="category_id"]');
    const mediaFile = this.querySelector('input[name="media_file"]');
    const mediaUrl = this.querySelector('input[name="media_url"]');
    
    if (!categorySelect.value) {
        alert('Please select a category');
        e.preventDefault();
        return;
    }
    
    if (!mediaFile.files.length && !mediaUrl.value.trim()) {
        alert('Please upload an image or provide an image URL');
        e.preventDefault();
        return;
    }
    
    if (mediaFile.files.length && mediaUrl.value.trim()) {
        alert('Please choose either file upload OR URL, not both');
        e.preventDefault();
        return;
    }
});