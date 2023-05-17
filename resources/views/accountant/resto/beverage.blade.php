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
                            <li class="breadcrumb-item active">Beverage</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_beverage"><i class="fa fa-plus"></i> Add Beverage</a>
                    </div>
                </div>
            </div>
			<!-- /Page Header -->

            {{-- message --}}
            {!! Toastr::message() !!}

            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Beverage Name</th>
                                    <th>Quantity</th>
                                    <th>Beverage Unit</th>
                                    <th>Beverage Unit Price</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($beverage as $key=>$items )                                
                                <tr>
                                    <td hidden class="id">{{ $items->id }}</td>
                                    <td>{{ ++$key }}</td>
                                    <td class="iname">{{ $items->iname }}</td>
                                    <td class="quantity">{{ $items->quantity}}</td>
                                    <td class="unit">{{ $items->unit }}</td>
                                    <td class="uprice">{{ $items->uprice }}</td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item beverageUpdate" data-toggle="modal" data-target="#edit_beverage"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a href="#" class="dropdown-item beverageDelete" data-toggle="modal" data-target="#delete_beverage"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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

        <!-- Add beverage Modal -->
        <div id="add_beverage" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Beverage</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('beverage/add/save') }}" method="POST">
                            @csrf
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Beverage Name</label>
                                       <input type="text" name="iname" class="form-control @error('iname') is-invalid @enderror" value="{{ old('iname') }}" placeholder="enter item names">
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <div class="form-group"> 
                                    <label>Quantity</label>
                                    <input class="form-control @error('quantity') is-invalid @enderror" type="text"  name="quantity" value="{{ old('quantity') }}" placeholder="Enter item quantity">
                                </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6">
                                    <div class="form-group"> 
                                    <label>Beverage Unit</label>
                                    <select class="form-control  @error('unit') is-invalid @enderror" name="unit" value="{{ old('unit') }}">
                                        <option>--please select--</option> 
                                     <option value="bottle">bottle</option> 
                                     <option value="package">package</option> 
                                     <option value="carton">carton</option>  
                                    </select>
                                </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <div class="form-group"> 
                                    <label>Beverage Unit Price</label>
                                    <input type="text" name="uprice" class="form-control @error('uprice') is-invalid @enderror" value="{{ old('uprice') }}" placeholder="enter unit price">
                                </div>
                            </div>
                            </div>
                            <br>
                            
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add beverage Modal -->
				
        <!-- Edit beverage Modal -->
        <div id="edit_beverage" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Beverage</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <div class="modal-body">
                        <form action="{{ route('beverage/update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="id" value="">
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Beverage Name</label>
                                        <input class="form-control" type="text" name="iname" id="iname" value="" />
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                    <label>Quantity</label>
                                    <input class="form-control" type="text" name="quantity" id="quantity" value=""/>
                                </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                    <label>Beverage Unit</label>
                                    <select class="form-control" name="unit" id="unit">
                                     <option value="bottle">bottle</option> 
                                     <option value="package">package</option> 
                                     <option value="carton">carton</option>  
                                    </select>
                                </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group"> 
                                    <label>Beverage Unit Price</label>
                                    <input type="text" name="uprice"  id="uprice" class="form-control">
                                </div>
                            </div>
                            </div>
                            <br>
                           
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit beverage Modal -->
				
        <!-- Delete beverage Modal -->
        <div class="modal custom-modal fade" id="delete_beverage" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Beverage</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('beverage/delete') }}" method="POST">
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
        <!-- /Delete beverage Modal -->
    </div>
    <!-- /Page Wrapper -->
    @section('script')


      {{-- update js --}}
      <script>
        $(document).on('click','.beverageUpdate',function()
        {
            var _this = $(this).parents('tr');
            $('#id').val(_this.find('.id').text());
            $('#iname').val(_this.find('.iname').text());
            $('#quantity').val(_this.find('.quantity').text());
            $('#unit').val(_this.find('.unit').text());
            $('#uprice').val(_this.find('.uprice').text());

            
            var unit = (_this.find(".unit").text());
                var _option = '<option selected value="' + unit+ '">' + _this.find('.unit').text() + '</option>'
                $( _option).appendTo("#unit");
               

        });
    </script>

    {{-- delete js --}}
    <script>
        $(document).on('click','.beverageDelete',function()
        {
            var _this = $(this).parents('tr');
            $('.id').val(_this.find('.id').text());
            
        });
    </script>

    @endsection

@endsection
