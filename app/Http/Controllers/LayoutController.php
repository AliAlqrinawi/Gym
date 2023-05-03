<?php

namespace App\Http\Controllers;

use App\Models\Layout;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class LayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Layout::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $image = '<img src="' . asset('/') . $row->image . '" alt="image" width="50" height="50">';
                    return $image;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button class="modal-effect btn btn-sm btn-info"  style="margin: 5px" id="showModalEditLayout" data-id="' . $row->id . '"><i class="las la-pen"></i></button>';
                    $btn = $btn . '<button class="modal-effect btn btn-sm btn-danger" style="margin: 5px" id="showModalDeleteLayout" data-name="' . $row->title_en . '" data-id="' . $row->id . '"><i class="las la-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns([
                    'image' => 'image',
                    'action' => 'action',
                ])
                ->make(true);
        }
        return view('dashboard.views-dash.layout.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $layoutData = $request->all();
        $validator = Validator($layoutData, [
            'title_en' => 'required|string|min:3|max:255',
            'title_ar' => 'required|string|min:3|max:255',
            'sud_title_ar' => 'required|string|min:3|max:255',
            'sud_title_en' => 'required|string|min:3|max:255',
            'description_en' => 'required|string|min:3|max:255',
            'description_ar' => 'required|string|min:3|max:255',
            'image' => 'required|image',
            'layout' => 'required|in:first,second,third',
        ]);
        if (!$validator->fails()) {
            if($request->hasFile('image')) {
                $name = Str::random(12);
                $image = $request->file('image');
                $imageName = $name . time() . '_' . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('image'), $imageName);
                $layoutData['image'] = 'image/' . $imageName;
            }
            $layout = Layout::create($layoutData);
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
        $layout = Layout::find($id);
        if ($layout) {
            $response = [
                'message' => __('success'),
                'status' => 200,
                'data' => $layout
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
        $layoutData = $request->all();
        $validator = Validator($layoutData, [
            'title_en' => 'required|string|min:3|max:255',
            'title_ar' => 'required|string|min:3|max:255',
            'sud_title_ar' => 'required|string|min:3|max:255',
            'sud_title_en' => 'required|string|min:3|max:255',
            'description_en' => 'required|string|min:3|max:255',
            'description_ar' => 'required|string|min:3|max:255',
            'image' => 'nullable|image',
            'layout' => 'required|in:first,second,third',
        ]);
        if (!$validator->fails()) {
            if($request->hasFile('image')) {
                $name = Str::random(12);
                $image = $request->file('image');
                $imageName = $name . time() . '_' . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('image'), $imageName);
                $layoutData['image'] = 'image/' . $imageName;
            }
            $layout = Layout::find($id)->update($layoutData);
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
        $layout = Layout::find($id);
        if ($layout) {
            $layout->delete();
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
        $layout = Layout::find($id);
        if ($layout) {
            $layout->changeStatus();
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
