@extends('dashboard.layouts.master')

@section('title', __('Setting'))

@section('content')
    <div class="main-body">
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@elseif( session('delete') )
<div class="alert alert-danger ">
    {{ session('delete') }}
</div>
@endif

<!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <h4> {{ __('Setting') }}</h4>
                <hr>
            </div>
            <div class="card-body">
                <form action="{{route('setting.update' , 1)}}" method="post" autocomplete="off"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @foreach ($settings as $key => $x)
                    <div class="form-group">
                        @if (App::getLocale() == 'en')
                        <label class="col-md-3 control-label" for="site_title">{{ $x->title_en }} : </label>
                        @else
                        <label class="col-md-3 control-label" for="site_title">{{ $x->title_ar }} : </label>
                        @endif
                        <div class="col-md-10">
                            <textarea id="site_title" name=" {{ $x->key_id }}"
                                class="form-control">@if(isset($x->value)){{$x->value}}@endif</textarea>
                        </div>
                    </div>
                    @endforeach
                    <hr>
                    <button type="submit" class="btn btn-info-gradient btn-block col-sm-2">
                        <a href="#" style="font-weight: bold; color: beige;">{{ __('Update') }}</a>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!--/div-->

    <!-- Modal effects -->
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{trans('users_admin.delete_users')}}</h6><button aria-label="Close"
                        class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="match/destroy" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>{{trans('users_admin.delete_message2')}}</p><br>
                        <input type="hidden" name="id" id="user_id" value="">
                        <input class="form-control" name="username" id="username" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{trans('users_admin.Close')}}</button>
                        <button type="submit" class="btn btn-danger">{{trans('users_admin.Submit')}}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>
<!-- /row -->
</div>
@endsection
