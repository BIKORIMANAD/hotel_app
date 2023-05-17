@extends('layouts.master')
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">		
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Bar Management</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Food</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_product"><i class="fa fa-plus"></i> Add Food</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Unit Price</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($foods as $key=>$items )                                
                                <tr>
                                    <td hidden class="id">{{ $items->id }}</td>
                                    <td>{{ ++$key }}</td>
                                    <td class="foodname">{{ $items->foodname }}</td>
                                    <td class="foodquantity">{{ $items->foodquantity}}</td>
                                    <td class="foodunit">{{ $items->foodunit }}</td>
                                    <td class="fooduprice">{{ $items->fooduprice }}</td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item edit_prod" data-toggle="modal" data-target="#edit_product"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a href="#" class="dropdown-item delete_prod" data-toggle="modal" data-target="#delete_product"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
        
        <!-- Add Job Modal -->
        <div id="add_product" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Food </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('bar/food/save') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input class="form-control @error('foodname') is-invalid @enderror" type="text" name="foodname" value="{{ old('foodname') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Quantity</label>
                                        <input class="form-control @error('foodquantity') is-invalid @enderror" type="text" name="foodquantity" value="{{ old('foodquantity') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Unit</label>
                                        <select class="form-control @error('foodunit') is-invalid @enderror select" type="text" name="foodunit" value="{{ old('foodunit') }}">
                                            <option> --Please Select-- </option>
                                        <option value="kg">kg</option>
                                        <option value="lit">lit</option>
                                        <option value="carton">carton</option>
                                        <option value="package">package</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Unit price</label>
                                        <input class="form-control @error('fodduprice') is-invalid @enderror" type="text" name="fooduprice" value="{{ old('fooduprice') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Job Modal -->
        
        <!-- Edit Job Modal -->
        <div id="edit_product" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Food</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('bar/food/update') }}" method="POST">
                            @csrf
                            <input class="form-control" type="hidden" id="id" name="id" value="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input class="form-control " type="text" name="foodname" id="foodname" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Quantity</label>
                                        <input class="form-control " type="text" name="foodquantity" id="foodquantity" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Unit</label>
                                        <select class="form-control select" type="text" name="foodunit" id="foodunit" value="">
                                        <option value="kg">kg</option>
                                        <option value="lit">lit</option>
                                        <option value="carton">carton</option>
                                        <option value="package">package</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Unit price</label>
                                        <input class="form-control " type="text" name="fooduprice" id="fooduprice" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Job Modal -->

        <!-- Delete Job Modal -->
        <div class="modal custom-modal fade" id="delete_product" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete food</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('bar/food/delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary continue-btn submit-btn">Delete</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Job Modal -->

    </div>
    <!-- /Page Wrapper -->

    @section('script')
        {{-- update --}}
        <script>
            $(document).on('click','.edit_prod',function()
            {
                var _this = $(this).parents('tr');
                $('#id').val(_this.find('.id').text());
                $('#foodname').val(_this.find('.foodname').text());
                $('#foodquantity').val(_this.find('.foodquantity').text());
                $('#foodunit').val(_this.find('.foodunit').text());
                $('#fooduprice').val(_this.find('.fooduprice').text());


                var foodunit = (_this.find(".foodunit").text());
                var _option = '<option selected value="' + foodunit+ '">' + _this.find('.foodunit').text() + '</option>'
                $( _option).appendTo("#foodunit");
               
            });
            
        </script>
          {{-- delete model --}}
      <script>
        $(document).on('click','.delete_prod',function()
        {
            var _this = $(this).parents('tr');
            $('.id').val(_this.find('.id').text());
        });
    </script>

       
    @endsection
@endsection
