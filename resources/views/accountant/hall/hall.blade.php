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
                        <h3 class="page-title">Hall Management</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Hall</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_hall"><i class="fa fa-plus"></i> Add Hall</a>
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
                        <table class="table table-striped custom-table" id="hallDataList" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Hall name</th>
                                    <th>Number of people</th>
                                    <th>Hall Price</th>
                                    <th>Status</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add User Modal -->
        <div id="add_hall" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Hall</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('hall/add/save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row"> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                        <label>Hall Name</label>
                                           <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name" id="" value="{{ old('name') }}" placeholder="enter hall name">
                                        </div>
                                    </div>
                                    
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                    <label>Number of People</label>
                                    <input type="text" class="form-control  @error('numberp') is-invalid @enderror" name="numberp" id="" value="{{ old('numberp') }}" placeholder="enter number of people">
                                </div>
                            </div>
                        </div>
            
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                    <label>Hall Price</label>
                                    <input class="form-control  @error('hallprice') is-invalid @enderror" type="text" id="" name="hallprice" value="{{ old('roomprice') }}" placeholder="Enter hall price">
                                </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                    <label>Hall Location</label>
                                    <select class="select form-control" name="location" id="location">
                                        <option selected disabled> --Select --</option>
                                        @foreach ($location as $locations )
                                        <option value="{{ $locations->location}}">{{ $locations->location }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            </div>

                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <label>Status</label>
                                    <select class="select" name="status" id="status">
                                        <option selected disabled> --Select --</option>
                                        @foreach ($status_hall as $status )
                                        <option value="{{ $status->type_name }}">{{ $status->type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Hall Image</label>
                                    <input class="form-control" type="file" id="image" name="image">
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
        <!-- /Add User Modal -->
				
        <!-- Edit User Modal -->
        <div id="edit_hall" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Hall</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <div class="modal-body">
                        <form action="{{ route('update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="">
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <label>Hall Name</label>
                            <input class="form-control" type="text" id="name" name="name" >
                                    </div>

                                <div class="col-sm-6"> 
                                    <label>Number of People</label>
                            <input class="form-control" type="text" id="numberp" name="numberp" >
                                </div>
                            </div>
                            
                            <br>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Hall Price</label>
                                    <input class="form-control" type="text" id="hallprice" name="hallprice" >
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                    <label>Hall Location</label>
                                    <select class="select form-control" name="location" id="location">
                                        <option selected disabled> --Select --</option>
                                        @foreach ($location as $locations )
                                        <option value="{{ $locations->location}}">{{ $locations->location }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                    <label>Status</label>
                                    <select class="select form-control" name="status" id="h_status">
                                        @foreach ($status_hall as $status )
                                        <option value="{{ $status->type_name }}">{{ $status->type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Hall Image</label>
                                    <input class="form-control" type="file" id="image" name="images">
                                    <input type="hidden" name="hidden_image" id="h_image" value="">
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
        <!-- /Edit Salary Modal -->
				
        <!-- Delete User Modal -->
        <div class="modal custom-modal fade" id="delete_hall" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Hall</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('hall/delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="id" value="">
                                <input type="hidden" name="avatar" id="avatar" value="">
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
        <!-- /Delete User Modal -->
    </div>
    <!-- /Page Wrapper -->
    @section('script')

    <script type="text/javascript">
        $(document).ready(function() {
            
            $('#hallDataList').DataTable({
                
                lengthMenu: [
                    [10, 25, 50, 100,150],
                    [10, 25, 50, 100,150]
                ],
                buttons: [
                    'pageLength',
                ],
                "pageLength": 10,
                order: [
                    [5, 'desc']
                ],
                processing: true,
                serverSide: true,
                ordering: true,
                searching: true,
                ajax: "{{ route('get-halls-data') }}",
                
                columns: [{
                        data: 'no',
                        name: 'no',
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'numberp',
                        name: 'numberp'
                    },
                    {
                        data: 'hallprice',
                        name: 'hallprice'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'location',
                        name: 'location',
                    },
                    {
                        data: 'action',
                        name: 'action',
                    },
                ]
            });

        });
    </script>

    {{-- update js --}}
    <script>
        $(document).on('click','.hallUpdate',function()
        {
            var _this = $(this).parents('tr');
            $('#id').val(_this.find('.id').text());
            $('#name').val(_this.find('.name').text());
            $('#numberp').val(_this.find('.numberp').text());
            $('#hallprice').val(_this.find('.hallprice').text());
            $('#image').val(_this.find('.avatar').data('avatar'));
            $('#h_status').val(_this.find('.status_s').text()).change();
            $('#location').val(_this.find('.location').text()).change();
        });
    </script>

    {{-- delete js --}}
    <script>
        $(document).on('click','.hallDelete',function()
        {
            var _this = $(this).parents('tr');
            $('.id').val(_this.find('.id').data('id'));
            $('#avatar').val(_this.find('.avatar').data('avatar'));
        });
    </script> 

    @endsection

@endsection
