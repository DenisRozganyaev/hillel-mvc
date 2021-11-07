@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <br>
                <h3 class="text-center">{{ __($product->title) }}</h3>
                <hr>
            </div>
            <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-md-12">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                        <div class="col-md-6">
                            <input id="title"
                                   type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   name="title"
                                   value="{{ $product->title }}"
                                   autocomplete="title"
                                   autofocus
                            >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="SKU" class="col-md-4 col-form-label text-md-right">{{ __('SKU') }}</label>
                        <div class="col-md-6">
                            <input id="SKU"
                                   type="text"
                                   class="form-control @error('SKU') is-invalid @enderror"
                                   name="SKU"
                                   value="{{ $product->SKU }}"
                                   autocomplete="SKU"
                                   autofocus
                            >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}</label>
                        <div class="col-md-6">
                            <input id="price"
                                   type="text"
                                   class="form-control @error('price') is-invalid @enderror"
                                   name="price"
                                   value="{{ $product->price }}"
                                   autocomplete="price"
                                   autofocus
                            >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="discount" class="col-md-4 col-form-label text-md-right">{{ __('Discount') }}</label>
                        <div class="col-md-6">
                            <input id="discount"
                                   type="text"
                                   class="form-control @error('discount') is-invalid @enderror"
                                   name="discount"
                                   value="{{ $product->discount }}"
                                   autocomplete="discount"
                                   autofocus
                            >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="in_stock" class="col-md-4 col-form-label text-md-right">{{ __('In Stock (Quantity)') }}</label>
                        <div class="col-md-6">
                            <input id="in_stock"
                                   type="number"
                                   class="form-control @error('in_stock') is-invalid @enderror"
                                   name="in_stock"
                                   value="{{ $product->in_stock }}"
                                   autocomplete="in_stock"
                            >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                        <div class="col-md-6">
                            <textarea name="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      cols="30"
                                      rows="10">{{ $product->description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="short_description" class="col-md-4 col-form-label text-md-right">{{ __('Short Description') }}</label>
                        <div class="col-md-6">
                            <textarea name="short_description"
                                      class="form-control @error('short_description') is-invalid @enderror"
                                      id="short_description"
                                      cols="30"
                                      rows="10">{{ $product->short_description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="categories" class="col-md-4 col-form-label text-md-right">{{ __('Categories') }}</label>
                        <div class="col-md-6">
                            <select name="category_id"
                                    id="category"
                                    class="form-control @error('category') is-invalid @enderror"
                            >
                                @foreach($categories as $category)
                                    <option value="{{ $category['id'] }}"
                                            {{ $category['id'] === $product->category->id ? 'selected' : '' }}
                                    >{{ $category['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="thumbnail" class="col-md-4 col-form-label text-md-right">{{ __('Thumbnail') }}</label>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    @if(Storage::has($product->thumbnail))
                                        <img src="{{ Storage::url($product->thumbnail) }}" class="card-img-top" style="max-width: 80%; margin: 0 auto; display: block;">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="thumbnail" id="thumbnail" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="images" class="col-md-4 col-form-label text-md-right">{{ __('Images') }}</label>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        @foreach($product->gallery as $image)
                                            @if(Storage::has($image->path))
                                              <div class="col-sm-12 d-flex justify-content-center align-items-center">
                                                  <img src="{{ Storage::url($image->path) }}" class="card-img-top" style="max-width: 80%; margin: 0 auto; display: block;">
                                                  <a data-image_id="{{ $image->id }}"
                                                     data-route="{{ route('ajax.products.images.delete', $image->id) }}"
                                                     class="btn btn-danger remove-product-image">x</a>
                                              </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="file" name="images[]" id="images" multiple>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 text-right">
                            <input type="submit" class="btn btn-info" value="Update Product">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="{{ secure_asset('js/product-images.js') }}" type="text/javascript"></script>
@endsection
