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
                        <h3 class="page-title">Room Management</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Room</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_room"><i class="fa fa-plus"></i> Add Room</a>
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
                        <table class="table table-striped custom-table" id="roomDataList" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Room type</th>
                                    <th>Room Area</th>
                                    <th>Room Price</th>
                                    <th>Room Bed</th>
                                    <th>Room Number</th>
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

        <!-- Add Room Modal -->
        <div id="add_room" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Room</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('room/add/save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row"> 
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                        <label>Room Type</label>
                                            <select class="select form-control" id="" name="roomtype">
                                                <option value="public">public</option>
                                                <option value="vip">vip</option>
                                                <option value="vvip">vvip</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                    <label>Room Area</label>
                                    <select class="select form-control" id="" name="roomarea">
                                        <option value="single">single</option>
                                        <option value="double">double</option>
                                       
                                    </select>
                                </div>
                            </div>
                            </div>

                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                    <label>Room Price</label>
                                    <input class="form-control  @error('roomprice') is-invalid @enderror" type="text" id="" name="roomprice" value="{{ old('roomprice') }}" placeholder="Enter price">
                                </div>
                                </div>

                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                    <label>Room Bed</label>
                                    <input class="form-control  @error('roombed') is-invalid @enderror" type="number" id="" name="roombed" value="{{ old('roombed') }}" placeholder="Enter number of bed">
                                </div>
                            </div>
                            </div>
            
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Room Number</label>
                                        <input class="form-control  @error('roomno') is-invalid @enderror" type="text" id="" name="roomno" value="{{ old('roomno') }}" placeholder="Enter room number">
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                    <label>Location</label>
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
                                        @foreach ($status_room as $status )
                                        <option value="{{ $status->type_name }}">{{ $status->type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6"> 
                                    <label>Room Image</label>
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
        <!-- /Add Room Modal -->
				
        <!-- Edit Room Modal -->
        <div id="edit_room" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Room</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <div class="modal-body">
                        <form action="{{ route('update/room') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="r_id" value="">
                            <div class="row"> 
                                <div class="col-sm-6">
                                    <div class="form-group"> 
                                    <label>Room Type</label>
                                    <select class="select form-control" id="r_roomtype" name="roomtype">
                                            <option value="public">public</option>
                                            <option value="vip">vip</option>
                                            <option value="vvip">vvip</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                    <label>Room Area</label>
                                    <select class="select form-control" id="r_roomarea" name="roomarea">
                                        <option value="single">single</option>
                                        <option value="double">double</option>
                                       
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6">
                                    <div class="form-group"> 
                                    <label>Room Price</label>
                                    <input class="form-control" type="text" id="r_roomprice" name="roomprice" >
                                </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                    <label>Room Bed</label>
                                    <input class="form-control" type="number" id="r_roombed" name="roombed" >
                                </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label>Room Number</label>
                                        <input class="form-control" type="number" id="r_rno" name="roomno" >
                                    </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                    <label>Location</label>
                                    <select class="select form-control" name="location" id="r_location">
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
                                    <select class="select form-control" name="status" id="r_status">
                                        @foreach ($status_room as $status )
                                        <option value="{{ $status->type_name }}">{{ $status->type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                    <label>Room Image</label>
                                    <input class="form-control" type="file" id="image" name="images">
                                    <input type="hidden" name="hidden_image" id="r_image" value="">
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
        <!-- /Edit room Modal -->
				
        <!-- Delete Room Modal -->
        <div class="modal custom-modal fade" id="delete_room" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Room</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('room/delete') }}" method="POST">
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
        <!-- /Delete Room Modal -->
    </div>
    <!-- /Page Wrapper -->
    @section('script')

    <script type="text/javascript">
        $(document).ready(function() {
            
            $('#roomDataList').DataTable({
                
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
                ajax: "{{ route('get-rooms-data') }}",
                
                columns: [{
                        data: 'no',
                        name: 'no',
                    },
                    {
                        data: 'roomtype',
                        name: 'roomtype'
                    },
                    {
                        data: 'roomarea',
                        name: 'roomarea'
                    },
                    {
                        data: 'roomprice',
                        name: 'roomprice'
                    },
                    {
                        data: 'roombed',
                        name: 'roombed'
                    },
                    {
                        data: 'roomno',
                        name: 'roomno'
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
        $(document).on('click','.roomUpdate',function()
        {
            var _this = $(this).parents('tr');
            $('#r_id').val(_this.find('.id').text());
            $('#r_roomprice').val(_this.find('.roomprice').text());
            $('#r_roombed').val(_this.find('.roombed').text());
            $('#r_rno').val(_this.find('.roomno').text());
            $('#r_image').val(_this.find('.avatar').data('avatar'));
            $('#r_status').val(_this.find('.status_s').text()).change();
            $('#r_location').val(_this.find('.location').text());


                var roomtype = (_this.find(".roomtype").text());
                var _option = '<option selected value="' + roomtype+ '">' + _this.find('.roomtype').text() + '</option>'
                $( _option).appendTo("#r_roomtype");

                var roomarea = (_this.find(".roomarea").text());
                var _option = '<option selected value="' + roomarea+ '">' + _this.find('.roomarea').text() + '</option>'
                $( _option).appendTo("#r_roomarea");

        });
    </script>

    {{-- delete js --}}
    <script>
        $(document).on('click','.roomDelete',function()
        {
            var _this = $(this).parents('tr');
            $('.id').val(_this.find('.id').data('id'));
            $('#avatar').val(_this.find('.avatar').data('avatar'));
        });
    </script> 

    @endsection

@endsection
