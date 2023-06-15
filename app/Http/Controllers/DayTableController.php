<?php

namespace App\Http\Controllers;

use App\Models\Muscle;
use App\Models\Table;
use App\Models\Video;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class DayTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $day = $request->day;
        $table = Table::where('is_parent' , 'inparent')->get();
        $videos = Video::get();
        if ($request->ajax()) {
            $data = Table::when($request->day != "null" , function($q) use ($request){
                $q->where('parent_id' , $request->day);
            })->where('is_parent' , 'muscle')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $image = '<img src="' . asset('/') . $row->image . '" alt="image" width="50" height="50">';
                    return $image;
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
                    $btn = '<button class="modal-effect btn btn-sm btn-info"  style="margin: 5px" id="showModalEditDayTable" data-id="' . $row->id . '"><i class="las la-pen"></i></button>';
                    $btn = $btn . '<button class="modal-effect btn btn-sm btn-danger" style="margin: 5px" id="showModalDeleteDayTable" data-name="' . $row->title_en . '" data-id="' . $row->id . '"><i class="las la-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns([
                    'image' => 'image',
                    'status' => 'status',
                    'action' => 'action',
                ])
                ->make(true);
        }
        return view('dashboard.views-dash.dayTable.index' , compact('table' , 'videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $table = Table::where('is_parent' , 'inparent')->get();
        $videos = [];
        $muscles = Muscle::get();
        if($request->ajax()){
            $videos = Video::when($request->muscle_id, function($q) use ($request){
                $q->where('muscle_id' , $request->muscle_id);
            })->get();
            return view('dashboard.views-dash.dayTable.videosInput' , compact('table' , 'videos' , 'muscles'));
        }
        return view('dashboard.views-dash.dayTable.create' , compact('table' , 'videos' , 'muscles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dayTableData = $request->all();
        return $dayTableData;
        $validator = Validator($dayTableData, [
            'title_en' => 'required|string|min:3|max:255',
            'title_ar' => 'required|string|min:3|max:255',
            'description_en' => 'required|string|min:3|max:255',
            'description_ar' => 'required|string|min:3|max:255',
            'image' => 'required|image',
            'id_videos' =>  'required|array|exists:videos,id',
            'parent_id' => 'required|exists:tables,id',
            'status' => 'required|in:active,inactive',
        ]);
        if (!$validator->fails()) {
            if($request->hasFile('image')) {
                $name = Str::random(12);
                $image = $request->file('image');
                $imageName = $name . time() . '_' . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('image'), $imageName);
                $dayTableData['image'] = 'image/' . $imageName;
            }
            $dayTableData['is_parent'] = 'muscle';
            $dayTable = Table::create($dayTableData);
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
        $data = Table::where('is_parent' , 'exercise')->find($id);
        return view('dashboard.views-dash.dayTable.show' , compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dayTable = Table::find($id);
        if ($dayTable) {
            $response = [
                'message' => __('success'),
                'status' => 200,
                'data' => $dayTable
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
        $dayTableData = $request->all();
        $validator = Validator($dayTableData, [
            'title_en' => 'required|string|min:3|max:255',
            'title_ar' => 'required|string|min:3|max:255',
            'description_en' => 'required|string|min:3|max:255',
            'description_ar' => 'required|string|min:3|max:255',
            'image' => 'nullable|image',
            'id_videos' =>  'required|exists:videos,id',
            'parent_id' => 'required|exists:tables,id',
            'status' => 'required|in:active,inactive',
        ]);
        if (!$validator->fails()) {
            if($request->hasFile('image')) {
                $name = Str::random(12);
                $image = $request->file('image');
                $imageName = $name . time() . '_' . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('image'), $imageName);
                $dayTableData['image'] = 'image/' . $imageName;
            }
            $dayTable = Table::find($id)->update($dayTableData);
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
        $dayTable = Table::find($id);
        if ($dayTable) {
            $dayTable->delete();
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
        $dayTable = Table::find($id);
        if ($dayTable) {
            $dayTable->changeStatus();
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
