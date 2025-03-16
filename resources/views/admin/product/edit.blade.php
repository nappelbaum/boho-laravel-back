@extends('layouts.admin')

@section('title', 'Редактирование продукта')

@section('content')

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Редактирование продукта: {{ $product['name'] }}</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->

      @if (session('success'))
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4 class="mb-1"><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
        </div>
      @endif

      @if (session('error'))
          <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4 class="mb-1"><i class="icon fa fa-check"></i>
                  {{ session('error') }}
              </h4>
          </div>
      @endif
      
      @if (session('errors'))
          <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-check"></i>
                  @foreach ($errors->all() as $error)
                      {{ $error }}
                  @endforeach
              </h4>
          </div>
      @endif
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary">
                <!-- form start -->
                <form action="{{ route('product.update', $product['id']) }}" method="POST" id="admin_product_form" onsubmit="onSubmitCreateProduct()">
                  @csrf
                  @method('PUT')

                  <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1" class="h5">Название продукта (уникальное название от 1 до 255 символов)</label>
                      <input type="text" value="{{ $product['name'] }}" class="form-control" id="exampleInputEmail1" name="name"
                        placeholder="Введите название продукта (например, Панно (изголовье, столешница) Balos)" required>
                    </div>

                    <div class="form-group">
                        <label class="h5">Выберите категории, к которым относится продукт</label>

                        @foreach ($categories as $category)
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input admin-category-id" type="checkbox" id="customCheckbox{{ $category['id'] }}" value="{{ $category['id'] }}"
                                  @foreach ($product->categories as $selectedCategory)
                                    @if ($selectedCategory->id == $category->id)
                                      checked
                                    @endif
                                  @endforeach
                                >
                                <label for="customCheckbox{{ $category['id'] }}" class="custom-control-label" style="font-weight: 400">{{ $category['long_name'] }}</label>
                            </div>
                        @endforeach

                        <input class="d-none" type="text" id="admin_category_ids" name="category_id">
                    </div>

                    <div class="form-group">
                      <label class="h5">Картинки продукта</label>
                      
                      <div class="products-images-wrapper d-flex mb-2" id="products-images-wrapper" style="gap: 15px; flex-wrap: wrap;">
                          @foreach ($product->images as $image)
                            <div class="position-relative" style="width: 120px; height: 120px; overflow: hidden;">
                              @php
                                  $filename = explode('\\', $image->main_path)[array_key_last(explode('\\', $image->main_path))];
                              @endphp
                              <img src="/{{ $image->main_path }}" alt="Файл {{ $filename }} был переименован или удален"
                                style="display: block; width: 150px; width: 100%; height: 100%; object-fit: cover;">
                              <input type="text" class="d-none" id="admin_image_path" value="{{ $image->main_path }}">
                              <button type="button" class="btn btn-danger btn-sm position-absolute admin-image-close" style="top: 0; right: 0; opacity: 0.8;">
                                  <i class="fas fa-trash"></i>
                              </button>
                            </div>
                          @endforeach
                      </div>

                      <input class="d-none" type="text" id="admin_images_paths" name="image_path" value="">
                      <a href="" class="popup_selector btn btn-secondary" data-inputid="feature_image">Добавить картинки</a>
                    </div>

                    <div class="form-group">
                        <label class="h5">Описание продукта</label>
                        <textarea name="description" class="editor">{{ $product['description'] }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3" class="h5">Материалы</label>
                        <input type="text" value="{{ $product['materials'] }}" class="form-control" id="exampleInputEmail3" name="materials">
                    </div>

                    <div class="form-group">
                      <label class="h5">Размеры и цены</label>
                      <div class="d-flex align-items-end">
                        <div class="sizes-wrapper">
                          @if(count($product->sizes))
                            @for ($i = 0; $i < count($product->sizes); $i++)
                              <div class="admin-sizes-block d-flex align-items-end mt-2 mr-4">
                                <div class="mr-3">
                                    <label for="admin_proportion">                          
                                        Размер, см (пример: 100х60x3)
                                    </label>
                                    <input type="text" class="form-control" id="admin_proportion" value="{{ $product->sizes[$i]->proportion }}"
                                      required
                                    >
                                </div>
                                <div class="mr-3">
                                    <label for="admin_cost">Цена, руб.</label>
                                    <input type="text" class="form-control" id="admin_cost" value="{{ $product->sizes[$i]->cost }}"
                                      required
                                    >
                                </div>
                                
                                <button type="button" class="btn btn-danger btn-sm d-block admin-size-close">
                                    <i class="fas fa-trash"></i>
                                </button>
                              </div>
                            @endfor
                          @endif
                        </div>

                        <button type="button" class="btn btn-secondary admin-sizes-btn d-block">Добавить размер</button>
                      </div>
                      
                      <input class="d-none" type="text" id="admin_sizes" name="sizes">
                      <input class="d-none" type="checkbox" id="admin_sizes_change" name="is_change">
                    </div>
                  </div>
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-lg" id="admin_product_submit">
                      Обновить продукт
                    </button>
                  </div>
                </form>
            </div>
        </div>
      </div>

      <div class="admin-create-product-loading">
        <div class="loading-ring"></div>
        <div class="loading-text">Data is loading. Please wait.</div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

@endsection