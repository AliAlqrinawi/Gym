<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Package::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    if(App::getLocale() == 'en'){
                        $title = $row->title_en;
                    }else{
                        $title = $row->title_ar;
                    }
                    return $title;
                })
                ->addColumn('description', function ($row) {
                    if(App::getLocale() == 'en'){
                        $description = Str::limit($row->description_en, 10 , ' ...?');
                    }else{
                        $description = Str::limit($row->description_ar, 10 , ' ...?');
                    }
                    return $description;
                })
                ->addColumn('title_duration', function ($row) {
                    if(App::getLocale() == 'en'){
                        $title = $row->title_duration_en;
                    }else{
                        $title = $row->title_duration_ar;
                    }
                    return $title;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 'active') {
                        $status = '<button class="modal-effect btn btn-sm btn-success" style="margin: 5px" id="status" data-id="' . $row->id . '" ><i class=" icon-check"></i></button>';
                    } else {
                        $status = '<button class="modal-effect btn btn-sm btn-danger" style="margin: 5px" id="status" data-id="' . $row->id . '" ><i class=" icon-check"></i></button>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button class="modal-effect btn btn-sm btn-info"  style="margin: 5px" id="showModalEditPackage" data-id="' . $row->id . '"><i class="las la-pen"></i></button>';
                    $btn = $btn . '<button class="modal-effect btn btn-sm btn-danger" style="margin: 5px" id="showModalDeletePackage" data-name="' . $row->title_en . '" data-id="' . $row->id . '"><i class="las la-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns([
                    'status' => 'status',
                    'action' => 'action',
                ])
                ->make(true);
        }
        return view('dashboard.views-dash.package.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $packageData = $request->all();
        $validator = Validator($packageData, [
            'title_en' => 'required|string|min:3|max:255',
            'title_ar' => 'required|string|min:3|max:255',
            'description_en' => 'required|string|min:3|max:255',
            'description_ar' => 'required|string|min:3|max:255',
            'title_duration_ar' => 'required|string|min:3|max:255',
            'title_duration_en' => 'required|string|min:3|max:255',
            'options' => 'required|string',
            'duration' => 'required|integer',
            'price' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);
        if (!$validator->fails()) {
            $options = explode(',',$request->options);
            $packageData['options'] = $options;
            $package = Package::create($packageData);
            $response = [
                'message' => __('Added successfully'),
                'status' => 200,
            ];
            return ControllersService::responseSuccess($response);
        } else {
            $response = [
                'message' => $validator->getMessageBag()->first(),
                'status' => 400,
            ];
            return ControllersService::responseErorr($response);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = Package::find($id);
        if ($package) {
            $response = [
                'message' => __('success'),
                'status' => 200,
                'data' => $package
            ];
            return ControllersService::responseSuccess($response);
        } else {
            $response = [
                'message' => __('Not Found Data'),
                'status' => 400,
            ];
            return ControllersService::responseErorr($response);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $packageData = $request->all();
        $validator = Validator($packageData, [
            'title_en' => 'required|string|min:3|max:255',
            'title_ar' => 'required|string|min:3|max:255',
            'description_en' => 'required|string|min:3|max:255',
            'description_ar' => 'required|string|min:3|max:255',
            'title_duration_ar' => 'required|string|min:3|max:255',
            'title_duration_en' => 'required|string|min:3|max:255',
            'options' => 'required|string',
            'duration' => 'required|integer',
            'price' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);
        if (!$validator->fails()) {
            $options = explode(',',$request->options);
            $packageData['options'] = $options;
            $package = Package::find($id)->update($packageData);
            $response = [
                'message' => __('Updated successfully'),
                'status' => 200,
            ];
            return ControllersService::responseSuccess($response);
        } else {
            $response = [
                'message' => $validator->getMessageBag()->first(),
                'status' => 400,
            ];
            return ControllersService::responseErorr($response);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = Package::find($id);
        if ($package) {
            $package->delete();
            $response = [
                'message' => __('Deleted successfully'),
                'status' => 200,
            ];
            return ControllersService::responseSuccess($response);
        } else {
            $response = [
                'message' => __('Not Found Data'),
                'status' => 400,
            ];
            return ControllersService::responseErorr($response);
        }
    }

    public function status($id)
    {
        $package = Package::find($id);
        if ($package) {
            $package->changeStatus();
            $response = [
                'message' => __('Updated successfully'),
                'status' => 200,
            ];
            return ControllersService::responseSuccess($response);
        } else {
            $response = [
                'message' => __('Not Found Data'),
                'status' => 400,
            ];
            return ControllersService::responseErorr($response);
        }
    }
}
