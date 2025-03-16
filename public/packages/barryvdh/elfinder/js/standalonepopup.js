$(document).on('click','.popup_selector',function (event) {
    event.preventDefault();
    var updateID = $(this).attr('data-inputid'); // Btn id clicked
    var elfinderUrl = '/elfinder/popup/';

    // trigger the reveal modal with elfinder inside
    var triggerUrl = elfinderUrl + updateID;
    $.colorbox({
        href: triggerUrl,
        fastIframe: true,
        iframe: true,
        width: '90%',
        height: '70%'
    });

});
// function to update the file selected by elfinder
function processSelectedFile(files) {
    files.forEach((file) => {
        if(file.mime === "image/jpeg" || file.mime === "image/png" || file.mime === "image/webp" || file.mime === "image/avif" || file.mime === "image/gif") {
            if(file.name.includes('#%?&') || file.name.includes('\\') || file.name.includes('/')) {
                const d = $('<div class="position-relative" style="width: 120px; height: 120px; overflow: hidden;"></div>')
                d.html(`
                    <div>Недопустимое имя файла (содержит символы '#%?&' или '/\\')</div>
                    <button type="button" class="btn btn-danger btn-sm delete-btn position-absolute admin-image-close" style="top: 0; right: 0; opacity: 0.8;">
                        <i class="fas fa-trash"></i>
                    </button>
                `);
                $('.products-images-wrapper').append(d);
    
                $('.admin-image-close').on( "click", function() {
                    this.parentElement.remove();
                    setImgInput();
                })
            } else {
                const d = $('<div class="position-relative" style="width: 120px; height: 120px; overflow: hidden;"></div>')
        
                d.html(`
                        <img src="/${file.path}" alt="${file.name}"
                        style="display: block; width: 150px; width: 100%; height: 100%; object-fit: cover;">
                        <input type="text" class="d-none" id="admin_image_path" value="${file.path}">
                        <button type="button" class="btn btn-danger btn-sm delete-btn position-absolute admin-image-close" style="top: 0; right: 0; opacity: 0.8;">
                            <i class="fas fa-trash"></i>
                        </button>
                    `);
               
                $('.products-images-wrapper').append(d);
        
                $('.admin-image-close').on( "click", function() {
                    this.parentElement.remove();
                    setImgInput();
                })
            }
        }
    })

    function setImgInput() {
        const imgs = [];
    
        document.querySelectorAll('#admin_image_path').forEach((path) => {
            imgs.push(path.value);
        })
        
        document.querySelector('#admin_images_paths').value = imgs.join('#%?&');
    }

    setImgInput();

    // $('#' + requestingField).val(filePath).trigger('change');
    // $('.img-uploaded').attr('src', '/' + filePath).trigger('change');
}
