
@extends('layouts.admin')

@section('title', 'Редактирование главной страницы')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактирование главной страницы</h1>
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
                        <form action="{{ route('pageMainUpdate') }}" method="POST" onsubmit="onSubmitCreateProduct()">
                            @csrf
                            @method('PATCH')
                            
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Имя автора</label>
                                    <input type="text" value="{{ $info['author_name'] }}" name="author_name" class="form-control"
                                        id="exampleInputEmail1" placeholder="Введите имя автора" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Слоган</label>
                                    <input type="text" value="{{ $info['slogan'] }}" name="slogan" class="form-control"
                                        id="exampleInputEmail1" placeholder="Введите слоган" required>
                                </div>

                                <div class="form-group">
                                    <label class="h5">Картинка</label>
                                    
                                    <div class="products-images-wrapper d-flex mb-2" id="products-images-wrapper" style="gap: 15px; flex-wrap: wrap;">
                                        <div class="position-relative" id="admin_main_image_wrapper" style="width: 280px; height: 280px; overflow: hidden;">
                                            @php
                                                $filename = explode('\\', $info['main_path'])[array_key_last(explode('\\', $info['main_path']))];
                                            @endphp
                                            <p style="color: red; font-weight: 800; margin-bottom: 0;"></p>
                                            <img src="/{{ $info['main_path'] }}" alt="Файл {{ $filename }} был переименован или удален"
                                                style="display: block; width: 100%; height: 100%; object-fit: cover;">
                                            <input class="d-none" type="text" id="admin_main_image_path" name="main_image_path" value="">
                                        </div>
                                    </div>
              
                                    <a href="" class="popup_selector btn btn-secondary" data-inputid="feature_image">Изменить картинку</a>
                                </div>
                            </div>

                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-lg">Обновить страницу</button>
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
    <!-- /.content -->
@endsection
