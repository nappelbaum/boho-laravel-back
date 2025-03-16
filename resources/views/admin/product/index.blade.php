@extends('layouts.admin')

@section('title', 'Список продуктов')

@section('content')

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12 d-flex justify-content-between">
          <div>
              <h1 class="m-0">Список продуктов</h1>
                @if (count($filter))
                    <h4>Показаны продукты из категории {{ $filter['long_name'] }}</h4>                               
                @endif
          </div>
          <button class="border-0 text-info" title="Фильтр" id="adminFilterToggleBtn">
            <i class="fas fa-solid fa-filter fa-2x"></i>
          </button>
        </div><!-- /.col -->
      </div><!-- /.row -->

      <div class="row mb-3 mt-3 d-none" id="adminFilterInfo">
        <h4 class="mb-3">Выводить продукты из категории:</h4>
        <div class="col-sm-12">
                <div class="form-group mb-3">
                    @foreach ($categories as $category)
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input admin-filter-radio" type="radio" id="catId{{ $category->id }}" name="filter" data-id="{{ $category->id }}"
                                @if (count($filter) && $filter['id'] == $category->id)
                                    checked                  
                                @endif
                            >
                            <label for="catId{{ $category->id }}" class="custom-control-label">{{ $category->long_name }}</label>
                        </div>
                    @endforeach
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input admin-filter-radio" type="radio" id="filterReset" name="filter" data-id="">
                        <label for="filterReset" class="custom-control-label">Сбросить фильтр</label>
                    </div>
                </div>
                <a href="{{ route('product.index') }}" id="adminFilterBtn" class="btn btn-info">Применить</a>
        </div><!-- /.col -->
      </div><!-- /.row -->

      @if (session('success') && session('success') != 'Продукт был успешно обновлен')
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4 class="mb-1"><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
        </div>
      @endif

      @if (session('errors'))
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4 class="mb-1"><i class="icon fa fa-check"></i>
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
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            {{-- <th style="width: 5%">
                                ID
                            </th> --}}
                            <th>
                                Название
                            </th>
                            <th>
                                <span>Дата создания</span>
                                @if ($method == 'asc')
                                    <a
                                        @if (count($filter))
                                            href="{{ route('product.index', ['filter' => $filter['id'], 'method' => 'desc']) }}"
                                        @else
                                            href="{{ route('product.index', 'method=desc') }}"
                                        @endif
                                        class="ml-2" title="Кликните для сортировки по убыванию">
                                            <i class="fas fa-solid fa-lg fa-caret-up"></i>
                                    </a>
                                @else
                                    <a
                                        @if (count($filter))
                                            href="{{ route('product.index', ['filter' => $filter['id'], 'method' => 'asc']) }}"
                                        @else
                                            href="{{ route('product.index', 'method=asc') }}"
                                        @endif
                                        class="ml-2" title="Кликните для сортировки по возрастанию">
                                            <i class="fas fa-solid fa-lg fa-caret-down"></i>
                                    </a>
                                @endif
                            </th>
                            <th style="width: 30%">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr id="editBlock">
                                    <td>
                                        <a href="{{ route('product.edit', $product['id']) }}" style="color: inherit">{{ $product['name'] }}</a><br/>
                                        @for ($i = 0; $i < count($product->categories); $i++)
                                            <span class="text-primary font-italic text-lowercase" style="font-size: 0.9rem;">
                                                {{ $product->categories[$i]->long_name }}@if($i < count($product->categories) - 1),@endif
                                            </span>
                                        @endfor
                                    </td>
                                    <td>
                                        {{ $product['created_at'] }}
                                    </td>

                                    <td class="project-actions text-right">
                                        <button class="btn btn-info btn-sm" id="openEditBtn">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <form action="{{ route('product.destroy', $product['id']) }}" method="POST"
                                            style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                            </tr>  
                            <tr id="hideEditBlock" class="d-none">
                                <td colspan="3" class="p-0">
                                        
                                    <form action="{{ route('product.update', $product['id']) }}" method="POST"
                                        class="w-100 d-flex bg-transparent">
                                        @csrf
                                        @method('PATCH')

                                        <div class="card-body w-100">
                                            <div class="form-group mb-1">
                                                <label for="exampleInputEmail1">Изменить дату, время</label>
                                                <input type="datetime-local" value="{{ $product['created_at'] }}" name="created_at" class="form-control"
                                                    id="exampleInputEmail1" required>
                                            </div>
                                        </div>

                                        <div class="card-body bg-transparent d-flex flex-column justify-between">
                                            <button type="submit" class="btn btn-primary btn-sm mb-2">Сохранить</button>

                                            <a class="btn btn-info btn-sm" href="{{ route('product.edit', $product['id']) }}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                                Редактировать запись
                                            </a>
                                        </div>
                                    </form>
                                
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div><!-- /.container-fluid -->
  </section>

@endsection