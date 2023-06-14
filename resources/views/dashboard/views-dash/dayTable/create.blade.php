@extends('dashboard.layouts.master')
@section('title', 'DayTable')
@section('css')
    <!-- Data table css -->
    <link href="{{ asset('assets/scss/plugins/dataTables.bootstrap5.scss') }}" rel="stylesheet" />
    <link href="{{ asset('assets/scss/plugins/buttons.bootstrap5.scss') }}" rel="stylesheet">
    <link href="{{ asset('assets/scss/plugins/responsive.bootstrap5.scss') }}" rel="stylesheet" />
@stop

@section('content')

    <div class="modal" id="modalDayTableAdd">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('DayTable') }}</h6>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <ul id="list_error_message"></ul>
                    <form id="formDayTableAdd" enctype="multipart/form-data">
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Title in English') }} :</label>
                                <input type="text" class="form-control" name="title_en" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Title in Arabic') }} :</label>
                                <input type="text" class="form-control" name="title_ar" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Description in English') }} :</label>
                                <input type="text" class="form-control" name="description_en" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Description in Arabic') }} :</label>
                                <input type="text" class="form-control" name="description_ar" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Image') }} :</label>
                                <input type="file" class="form-control" name="image" required>
                            </div>

                            <div class="form-group col-md-6">
                                <p class="mg-b-10">{{ __('Videos') }}</p>
                                <select name="id_videos[]" multiple="multiple" class="testselect2">
                                    @foreach ($videos as $key => $value)
                                        <option {{ $key == 0 ? 'selected' : '' }} value="{{ $value->id }}">
                                            {{ app()->getLocale() == 'en' ? $value->title_en : $value->title_ar }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Parent') }} :</label>
                                <select name="parent_id" class="form-control">
                                    @foreach ($table as $value)
                                        <option value="{{ $value->id }}">
                                            {{ app()->getLocale() == 'en' ? $value->title_en : $value->title_ar }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Status') }} :</label>
                                <select name="status" class="form-control">
                                    <option value="active">{{ __('ACTIVE') }}</option>
                                    <option value="inactive">{{ __('NACTIVE') }}</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="addDayTable">{{ __('Save') }}</button>
                            <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button"
                                id="close">{{ __('Close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="row row-xs wd-xl-80p">
                        <div class="col-sm-6 col-md-3 mg-t-10">
                            <h2></h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="formDayTableAdd" enctype="multipart/form-data">
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Title in English') }} :</label>
                                <input type="text" class="form-control" name="title_en" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Title in Arabic') }} :</label>
                                <input type="text" class="form-control" name="title_ar" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Description in English') }} :</label>
                                <input type="text" class="form-control" name="description_en" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Description in Arabic') }} :</label>
                                <input type="text" class="form-control" name="description_ar" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Image') }} :</label>
                                <input type="file" class="form-control" name="image" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ __('Status') }} :</label>
                                <select name="status" class="form-control">
                                    <option value="active">{{ __('ACTIVE') }}</option>
                                    <option value="inactive">{{ __('NACTIVE') }}</option>
                                </select>
                            </div>

                            <div id="repeater" style="width: 100%">
                                <!-- Repeater Heading -->
                                <div class="repeater-heading">
                                    <a class="btn btn-primary pull-right repeater-add-btn">
                                        Add
                                    </a>
                                </div>
                                <div class="clearfix"></div>
                                <!-- Repeater Items -->
                                <div class="items" data-group="test">
                                    <!-- Repeater Content -->

                                    <div class="item-content row">
                                        <div class="form-group col-md-6">
                                            <p class="mg-b-10">{{ __('Muscles') }}</p>
                                            <select name="id_muscles" onchange="onchange1(this)" data-name="id_muscles"
                                                id="muscles" class="form-control ali">
                                                @foreach ($muscles as $key => $value)
                                                    <option {{ $key == 0 ? 'selected' : '' }}
                                                        value="{{ $value->id }}">
                                                        {{ app()->getLocale() == 'en' ? $value->title_en : $value->title_ar }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            @include('dashboard.views-dash.dayTable.videosInput')
                                        </div>
                                        <script>
                                            window.asd = $('.SlectBox').SumoSelect({
                                                csvDispCount: 3,
                                                selectAll: true,
                                                captionFormatAllSelected: "Yeah, OK, so everything."
                                            });
                                            window.Search = $('.search-box').SumoSelect({
                                                csvDispCount: 3,
                                                search: true,
                                                searchText: 'Enter here.'
                                            });
                                            window.sb = $('.SlectBox-grp-src').SumoSelect({
                                                csvDispCount: 3,
                                                search: true,
                                                searchText: 'Enter here.',
                                                selectAll: true
                                            });
                                            $('.testselect1').SumoSelect();
                                            $('.testselect2').SumoSelect();
                                            $('.selectsum1').SumoSelect({
                                                okCancelInMulti: true,
                                                selectAll: true
                                            });
                                            $('.selectsum2').SumoSelect({
                                                selectAll: true
                                            });
                                        </script>
                                    </div>

                                    <!-- Repeater Remove Btn -->
                                    <div class="pull-right repeater-remove-btn">
                                        <button class="btn btn-danger remove-btn">
                                            Remove
                                        </button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <input type="hidden" name="parent_id" value="{{ request()->day }}">

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="addDayTable">{{ __('Save') }}</button>
                            <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button"
                                id="close">{{ __('Close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('dashboard/repeater.js') }}"></script>
    <script>
        $("#repeater").createRepeater({
            showFirstItemToDefault: true,
        });
    </script>
    <script>
        function onchange1(i) {
            $.ajax({
                type: 'GET',
                url: "{{ route('dayTable.create') }}",
                data: {
                    "muscle_id": i.value
                },
                success: function(response) {
                    i.parentNode.nextElementSibling.innerHTML = response
                    window.asd = $('.SlectBox').SumoSelect({
                        csvDispCount: 3,
                        selectAll: true,
                        captionFormatAllSelected: "Yeah, OK, so everything."
                    });
                    window.Search = $('.search-box').SumoSelect({
                        csvDispCount: 3,
                        search: true,
                        searchText: 'Enter here.'
                    });
                    window.sb = $('.SlectBox-grp-src').SumoSelect({
                        csvDispCount: 3,
                        search: true,
                        searchText: 'Enter here.',
                        selectAll: true
                    });
                    $('.testselect1').SumoSelect();
                    $('.testselect2').SumoSelect();
                    $('.selectsum1').SumoSelect({
                        okCancelInMulti: true,
                        selectAll: true
                    });
                    $('.selectsum2').SumoSelect({
                        selectAll: true
                    });
                }
            });
        }
    </script>
    <script src="{{ asset('dashboard/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <script src="{{ asset('dashboard/js/advanced-form-elements.js') }}"></script>
@stop
