@extends('dashboard.layouts.master')
@section('title', 'Table')
@section('css')
    <!-- Data table css -->
    <link href="{{ asset('assets/scss/plugins/dataTables.bootstrap5.scss') }}" rel="stylesheet" />
    <link href="{{ asset('assets/scss/plugins/buttons.bootstrap5.scss') }}" rel="stylesheet">
    <link href="{{ asset('assets/scss/plugins/responsive.bootstrap5.scss') }}" rel="stylesheet" />
@stop

@section('content')

    <div class="row row-sm">
        <div id="error_message"></div>
        <div class="modal" id="modalTableAdd">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Table</h6>
                        <button aria-label="Close" class="close"
                        data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <ul id="list_error_message"></ul>
                        <form id="formTableAdd" enctype="multipart/form-data">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">Title :</label>
                                    <input type="text" class="form-control" name="title_en" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">Question :</label>
                                    <input type="text" class="form-control" name="question_en" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">Answer :</label>
                                    <textarea class="form-control" name="answer_en" rows="3" required></textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">Image :</label>
                                    <input type="file" class="form-control" name="image">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">Status :</label>
                                    <select name="status" class="form-control">
                                        <option value="ACTIVE">ACTIVE</option>
                                        <option value="NACTIVE">NACTIVE</option>
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" id="addTable">Save</button>
                                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Basic modal -->
        <div class="modal" id="modalTableUpdate">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Update Table</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <ul id="list_error_message2"></ul>
                        <form id="formTableUpdate" enctype="multipart/form-data">
                            @method('PUT')
                            <input type="hidden" class="form-control" name="id" id="id">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">Title :</label>
                                    <input type="text" class="form-control" id="title_en" name="title_en" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">Question :</label>
                                    <input type="text" class="form-control" id="question_en" name="question_en" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">Answer :</label>
                                    <textarea class="form-control" id="answer_en" name="answer_en" rows="3" required></textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">Image :</label>
                                    <input type="file" class="form-control" name="image">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">Status :</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="ACTIVE">ACTIVE</option>
                                        <option value="NACTIVE">NACTIVE</option>
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" id="updateTable">Update</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Basic modal -->

        <div class="modal" id="modalTableDelete" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Delete Operation</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">×</span></button>
                    </div>
                    <ul id="list_error_message3"></ul>
                    <div class="modal-body">
                        <p>Are sure of the deleting process?</p><br>
                        <input class="form-control" id="nameDetele" type="text" readonly="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" id="deleteTable">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-header pb-0">
                        <div class="row row-xs wd-xl-80p">
                            <div class="col-sm-6 col-md-3 mg-t-10">
                                <button class="btn btn-info-gradient btn-block" id="ShowModalTable"
                                    style="font-weight: bold; color: beige;">Addition
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive hoverable-table">
                            <table class="table table-hover" id="get_table" style=" text-align: center;">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">Title</th>
                                        <th class="border-bottom-0">Description</th>
                                        <th class="border-bottom-0">Status</th>
                                        <th class="border-bottom-0">Processes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- DATA TABLE JS -->
    <script src="{{ asset('dashboard/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/table-data.js') }}"></script>
    <script src="{{ asset('dashboard/local/table.js') }}"></script>
@stop
