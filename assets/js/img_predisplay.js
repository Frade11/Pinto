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