
document.querySelectorAll('#editBlock')?.forEach((block) => {
    block.querySelector('#openEditBtn').addEventListener('click', () => {
        block.nextElementSibling.classList.toggle('d-none');
    })
})

const catInputs = document.querySelectorAll('.admin-category-id');
const catInput = document.querySelector('#admin_category_ids');

catInputs?.forEach((input) => {
    input.addEventListener('change', () => {
        const cats = [];
        catInputs.forEach((inp) => {
            if(inp.checked) cats.push(inp.value);
        })
        catInput.value = cats.join(',');
    })
})

function addSizeBlock() {
    const newSizesGroup = document.createElement("div");
    newSizesGroup.classList.add('admin-sizes-block', 'd-flex', 'align-items-end', 'mt-2', 'mr-4');
    newSizesGroup.innerHTML = `
        <div class="mr-3">
            <label for="admin_proportion">Размер, см (пример: 100х60x3)</label>
            <input type="text" class="form-control" id="admin_proportion" required>
        </div>
        <div class="mr-3">
            <label for="admin_cost">Цена, руб.</label>
            <input type="text" class="form-control" id="admin_cost" required>
        </div>
        <button type="button" class="btn btn-danger btn-sm d-block admin-size-close">
            <i class="fas fa-trash"></i>
        </button>
    `
    document.querySelector('.sizes-wrapper').append(newSizesGroup);
    newSizesGroup.querySelector('#admin_proportion').focus();

    newSizesGroup.querySelector('.admin-size-close').addEventListener('click', () => {
        newSizesGroup.remove();
        if(document.querySelector('#admin_sizes_change')) document.querySelector('#admin_sizes_change').checked = true;
    })

    newSizesGroup.querySelector('#admin_proportion').addEventListener('change', () => {
        if(document.querySelector('#admin_sizes_change')) document.querySelector('#admin_sizes_change').checked = true;
    })
    newSizesGroup.querySelector('#admin_cost').addEventListener('change', () => {
        if(document.querySelector('#admin_sizes_change')) document.querySelector('#admin_sizes_change').checked = true;
    })
}

document.querySelector('.admin-sizes-btn')?.addEventListener('click', addSizeBlock)
document.querySelector('.admin-sizes-btn')?.addEventListener('keydown', (e) => {
    if(e.code == 'Enter') addSizeBlock()
})

document.querySelector('#admin_product_submit')?.addEventListener('focus', () => {
    const sizes = [];
    document.querySelectorAll('#admin_proportion').forEach((size, index) => {
        if(size.value && document.querySelectorAll('#admin_cost')[index].value) {
            sizes.push({
                size: size.value,
                cost: document.querySelectorAll('#admin_cost')[index].value
            })
        }
    })

    if(sizes.length) document.querySelector('#admin_sizes').value = JSON.stringify(sizes);
    else document.querySelector('#admin_sizes').value = '';
})

document.querySelector('#admin_product_form')?.addEventListener('keydown', (e) => {
    if (e.key === "Enter"
        && document.querySelector('#admin_product_submit') != document.activeElement
        && document.querySelector('.ck-content') != document.activeElement) {
        e.preventDefault();
      }
})

function onSubmitCreateProduct() {
    document.querySelector('.admin-create-product-loading').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

document.addEventListener('DOMContentLoaded', () => {
    if(document.querySelector('.admin-create-product-loading')) {
        document.querySelector('.admin-create-product-loading').style.display = 'none';
        document.body.style.overflow = 'visible';
    }

    const url = new URL(window.location)
    if(url.searchParams.get('filter')) {
        const anchor = document.getElementById("adminFilterBtn");
        if(url.searchParams.get('method')) url.searchParams.delete('method');
        anchor.href = url.href;
    }

    document.querySelectorAll('.admin-image-close')?.forEach((closeBtn) => {
        closeBtn.addEventListener('click', function() {
            this.parentElement.remove();
            setImgInput();
        })
    })

    const newSizesGroups = document.querySelectorAll('.admin-sizes-block')
    if(newSizesGroups.length) {
        newSizesGroups.forEach((newSizesGroup) => {
            newSizesGroup.querySelector('.admin-size-close')?.addEventListener('click', () => {
                newSizesGroup.remove();
                if(document.querySelector('#admin_sizes_change')) document.querySelector('#admin_sizes_change').checked = true;
            })
        })
    }
})

document.querySelector('#adminFilterToggleBtn')?.addEventListener('click', () => {
    document.querySelector('#adminFilterInfo').classList.toggle('d-none');
})

document.querySelectorAll('.admin-filter-radio')?.forEach((btn) => {
    btn.addEventListener('change', () => {
        if(btn.checked) {
            const anchor = document.getElementById("adminFilterBtn");
            const url = new URL(anchor.href);
            if(url.searchParams.get('method')) url.searchParams.delete('method');
            btn.dataset.id ? url.searchParams.set('filter', btn.dataset.id) : url.searchParams.delete('filter');
            anchor.href = url.href;
        }
    })
})

function setImgInput() {
    const imgs = [];

    document.querySelectorAll('#admin_image_path')?.forEach((path) => {
        imgs.push(path.value);
    })
    
    if(document.querySelector('#admin_images_paths'))
        document.querySelector('#admin_images_paths').value = imgs.join('#%?&');
}

document.querySelectorAll('#admin_proportion')?.forEach((size) => {
    size.addEventListener('change', () => {
        if(document.querySelector('#admin_sizes_change')) document.querySelector('#admin_sizes_change').checked = true
    })
})
document.querySelectorAll('#admin_cost')?.forEach((cost) => {
    cost.addEventListener('change', () => {
        if(document.querySelector('#admin_sizes_change')) document.querySelector('#admin_sizes_change').checked = true
    })
})