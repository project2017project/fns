<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use App\Models\ECatalogue;
use Illuminate\Http\Request;

class ECatalogueController extends Controller
{
    public function index()
    {
        return view('admin.ecatalogue.index');
    }

    public function datatables()
    {
        $datas = ECatalogue::latest('id')->get();

        return \Datatables::of($datas)
                    ->addColumn('action', function (ECatalogue $data) {
                        return '<div class="action-list"><a href="'.route('admin-edit-e-catalogue', $data->id).'" class="edit"> <i class="fas fa-edit"></i>'.__('Edit').'</a><a href="javascript:;" data-href="'.route('admin-delete-e-catalogue', $data->id).'" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                    })
                    ->addColumn('file', function (ECatalogue $data) {
                        $filelink = asset('assets/images/e_catalogue').'/'.$data->e_catalogue_file;

                        return '<div class="action-list"><a target="_blank" href="'.$filelink.'" class="edit"><i class="fa fa-file-download"></i> Download File</a></div>';
                    })
                    ->rawColumns(['action', 'file'])
                    ->toJson(); // --- Returning Json Data To Client Side
    }

    public function create()
    {
        return view('admin.ecatalogue.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'title' => 'required|string|unique:e_catalogues,title',
           'e_catalogue_file' => 'required|mimes:pdf',
        ]);
        $data = new ECatalogue();
        $input = $request->all();
        if ($file = $request->file('e_catalogue_file')) {
            $name = PriceHelper::ImageCreateName($file);
            $file->move('assets/images/e_catalogue', $name);
            $input['e_catalogue_file'] = $name;
        }
        $data->fill($input)->save();
        // --- Logic Section Ends

        // --- Redirect Section
        $msg = __('New Data Added Successfully.');

        return redirect()->route('admin.ecatalogue.list')->with('sucess', $msg);
    }

    public function edit($id)
    {
        try {
            $catalogueId = (int) $id;
            if (!empty($catalogueId)) {
                $data = ECatalogue::findOrFail($catalogueId);

                return view('admin.ecatalogue.edit', compact('data'));
            } else {
                throw new \Exception('Invalid Access');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.ecatalogue.list')->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $catalogueId = (int) $id;
        if (!empty($catalogueId)) {
            $this->validate($request, [
               'title' => 'required|string|unique:e_catalogues,title,'.$catalogueId,
               'e_catalogue_file' => 'mimes:pdf',
            ]);
            $data = ECatalogue::findOrFail($id);
            $input = $request->all();
            if ($file = $request->file('e_catalogue_file')) {
                $name = PriceHelper::ImageCreateName($file);
                $file->move('assets/images/e_catalogue', $name);
                if ($data->e_catalogue_file != null) {
                    if (file_exists(public_path().'/assets/images/e_catalogue/'.$data->e_catalogue_file)) {
                        unlink(public_path().'/assets/images/e_catalogue/'.$data->e_catalogue_file);
                    }
                }
                $input['e_catalogue_file'] = $name;
            }
            $data->update($input);
            // --- Logic Section Ends

            // --- Redirect Section
            $msg = __('Data Updated Successfully.');

            return redirect()->route('admin.ecatalogue.list')->with('sucess', $msg);
        }
    }

    public function destroy($id)
    {
        $data = ECatalogue::findOrFail($id);
        if (file_exists(public_path().'/assets/images/e_catalogue/'.$data->e_catalogue_file)) {
            unlink(public_path().'/assets/images/e_catalogue/'.$data->e_catalogue_file);
        }
        $data->delete();
        // --- Redirect Section
        $msg = __('Data Deleted Successfully.');

        return response()->json($msg);
    }
}
