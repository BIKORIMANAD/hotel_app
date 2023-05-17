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
                        <h3 class="page-title">Restaurant Management</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Materials</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_material"><i class="fa fa-plus"></i> Add Material</a>
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
                                    <th>Material Name</th>
                                    <th>Quantity</th>
                                    <th>MaterialUnit</th>
                                    <th>Material Unit Price</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materials as $key=>$items )                                
                                <tr>
                                    <td hidden class="id">{{ $items->id }}</td>
                                    <td>{{ ++$key }}</td>
                                    <td class="name">{{ $items->name }}</td>
                                    <td class="quantity">{{ $items->quantity}}</td>
                                    <td class="unit">{{ $items->unit }}</td>
                                    <td class="uprice">{{ $items->uprice }}</td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item edit_material" data-toggle="modal" data-target="#edit_material"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a href="#" class="dropdown-item delete_material" data-toggle="modal" data-target="#delete_material"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
        
        <!-- Add Material Modal -->
        <div id="add_material" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Material </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('resto/material/save') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Material Name</label>
                                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" placeholder="enter material name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Material Quantity</label>
                                        <input class="form-control @error('quantity') is-invalid @enderror" type="text" name="quantity" value="{{ old('quantity') }}" placeholder="enter material quantity">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Material Unit</label>
                                        <select class="form-control @error('unit') is-invalid @enderror select" type="text" name="unit" value="{{ old('unit') }}">
                                            <option> --Please Select-- </option>
                                        <option value="piece">piece</option>
                                        <option value="lit">lit</option>
                                        <option value="carton">carton</option>
                                        <option value="package">package</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Material Unit price</label>
                                        <input class="form-control @error('uprice') is-invalid @enderror" type="text" name="uprice" value="{{ old('uprice') }}" placeholder="enter unit price">
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
        <!-- /Add Material Modal -->
        
        <!-- Edit Material Modal -->
        <div id="edit_material" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('resto/material/update') }}" method="POST">
                            @csrf
                            <input class="form-control" type="hidden" id="id" name="id" value="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Material Name</label>
                                        <input class="form-control " type="text" name="name" id="name" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Material Quantity</label>
                                        <input class="form-control " type="text" name="quantity" id="quantity" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Material Unit</label>
                                        <select class="form-control select" type="text" name="unit" id="unit" value="">
                                        <option value="piece">piece</option>
                                        <option value="lit">lit</option>
                                        <option value="carton">carton</option>
                                        <option value="package">package</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Material Unit price</label>
                                        <input class="form-control " type="text" name="uprice" id="uprice" value="">
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
        <!-- /Edit Material Modal -->

        <!-- Delete Material Modal -->
        <div class="modal custom-modal fade" id="delete_material" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Material</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('resto/material/delete') }}" method="POST">
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
        <!-- /Delete Material Modal -->

    </div>
    <!-- /Page Wrapper -->

    @section('script')
        {{-- update --}}
        <script>
            $(document).on('click','.edit_material',function()
            {
                var _this = $(this).parents('tr');
                $('#id').val(_this.find('.id').text());
                $('#name').val(_this.find('.name').text());
                $('#quantity').val(_this.find('.quantity').text());
                $('#unit').val(_this.find('.unit').text());
                $('#uprice').val(_this.find('.uprice').text());


                var unit = (_this.find(".unit").text());
                var _option = '<option selected value="' + unit+ '">' + _this.find('.unit').text() + '</option>'
                $( _option).appendTo("#unit");
               
            });
            
        </script>
          {{-- delete model --}}
      <script>
        $(document).on('click','.delete_material',function()
        {
            var _this = $(this).parents('tr');
            $('.id').val(_this.find('.id').text());
        });
    </script>

       
    @endsection
@endsection
