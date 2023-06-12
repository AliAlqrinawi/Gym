<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Table::where('is_parent' , 'parent')->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title1', function ($row) {
                    if (App::getLocale() == 'en') {
                        return $row->title_en;
                    } else {
                        return $row->title_ar;
                    }
                })
                ->addColumn('description', function ($row) {
                    if (App::getLocale() == 'en') {
                        $description = Str::limit($row->description_en, 10, ' ...?');
                    } else {
                        $description = Str::limit($row->description_ar, 10, ' ...?');
                    }
                    return $description;
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
                    $btn = '<a class="modal-effect btn btn-sm btn-secondary" style="margin: 5px" href="' . url('business.index') . '?table=' . $row->id . '"><i class="las la-clipboard"></i></a>';
                    $btn = $btn . '<button class="modal-effect btn btn-sm btn-info"  style="margin: 5px" id="showModalEditTable" data-id="' . $row->id . '"><i class="las la-pen"></i></button>';
                    $btn = $btn . '<button class="modal-effect btn btn-sm btn-danger" style="margin: 5px" id="showModalDeleteTable" data-name="' . $row->title_en . '" data-id="' . $row->id . '"><i class="las la-trash"></i></button>';
                    return $btn;
                })
                // ->filter(function ($q) use ($request) {
                //     if ($request->status == 'active' || $request->status == 'inactive') {
                //         $q->where('status', $request->status);
                //     }
                    // if (!empty($request->get('search'))) {
                    //     $instance->where(function ($w) use ($request) {
                    //         $search = $request->get('search');
                    //         $w->orWhere('name', 'LIKE', "%$search%")
                    //             ->orWhere('email', 'LIKE', "%$search%");
                    //     });
                    // }
                // })
                ->rawColumns([
                    'status' => 'status',
                    'title1' => 'title1',
                    'action' => 'action',
                ])
                ->make(true);
        }
        return view('dashboard.views-dash.table.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tableData = $request->all();
        $validator = Validator($tableData, [
            'title_en' => 'required|string|min:3|max:255',
            'title_ar' => 'required|string|min:3|max:255',
            // 'description_en' => 'required|string|min:3|max:255',
            // 'description_ar' => 'required|string|min:3|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        if (!$validator->fails()) {
            $table = Table::create($tableData);
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
        $table = Table::find($id);
        if ($table) {
            $response = [
                'message' => __('success'),
                'status' => 200,
                'data' => $table
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
        $tableData = $request->all();
        $validator = Validator($tableData, [
            'title_en' => 'required|string|min:3|max:255',
            'title_ar' => 'required|string|min:3|max:255',
            // 'description_en' => 'required|string|min:3|max:255',
            // 'description_ar' => 'required|string|min:3|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        if (!$validator->fails()) {
            $table = Table::find($id)->update($tableData);
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
        $table = Table::find($id);
        if ($table) {
            $table->delete();
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
        $table = Table::find($id);
        if ($table) {
            $table->changeStatus();
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
