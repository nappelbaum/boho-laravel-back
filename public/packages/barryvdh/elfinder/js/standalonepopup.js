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
    const pathnameArr = window.location.pathname.split('/')
    if(pathnameArr[pathnameArr.length - 1] == 'main') {
        if(files[0].mime === "image/jpeg" || files[0].mime === "image/png" || files[0].mime === "image/webp" || files[0].mime === "image/avif" || files[0].mime === "image/gif") {
            const imageWrapper = document.querySelector('#admin_main_image_wrapper');

            if(files[0].name.includes('#%?&') || files[0].name.includes('#%&') || files[0].name.includes('\\') || files[0].name.includes('/')) {
                imageWrapper.querySelector('p').textContent = "Недопустимое имя файла (содержит символы '#%?&' или '/\\')";
                imageWrapper.querySelector('img').src = "/";
                imageWrapper.querySelector('img').alt = "Недопустимое имя файла (содержит символы '#%?&' или '/\\')";
            } else {
                imageWrapper.querySelector('img').src = `/${files[0].path}`;
                imageWrapper.querySelector('img').alt = files[0].name;
                imageWrapper.querySelector('input').value = files[0].path;
            }
        }
    } else {
        files.forEach((file) => {
            if(file.mime === "image/jpeg" || file.mime === "image/png" || file.mime === "image/webp" || file.mime === "image/avif" || file.mime === "image/gif") {
                if(file.name.includes('#%?&') || files[0].name.includes('#%&') || file.name.includes('\\') || file.name.includes('/')) {
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
        
        setImgInput(); 
    }
    
    function setImgInput() {
        const imgs = [];
    
        const imgsPaths = document.querySelectorAll('#admin_image_path');

        if(imgsPaths.length) {
            imgsPaths.forEach((path) => {
                imgs.push(path.value);
            })

            document.querySelector('#admin_images_paths').value = imgs.join('#%?&');
        }
        
    }

    // $('#' + requestingField).val(filePath).trigger('change');
    // $('.img-uploaded').attr('src', '/' + filePath).trigger('change');
}
