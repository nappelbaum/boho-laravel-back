@extends('layouts.admin')

@section('title', 'Добавить категорию')

@section('content')

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Добавить категорию</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->

      @if (session('success'))
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4 class="mb-1"><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
        </div>
      @endif

      @if (session('errors'))
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4 class="mb-1"><i class="icon fa fa-check"></i>
                {{-- @if ($errors->has('long_name'))
                    Категория с таким названием уже есть
                @endif --}}
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
                <form action="{{ route('category.store') }}" method="POST" onsubmit="onSubmitCreateProduct()">
                  @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1" class="h5">Название категории</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" name="long_name"
                        placeholder="Введите название категории (например, Панно или Столешницы или Готовые товары)" required>
                    </div>

                    <div class="form-group">
                      <label class="h5">Описание категории</label>
                      <textarea name="description" class="editor"></textarea>
                    </div>
                  </div>
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-lg">Добавить категорию</button>
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