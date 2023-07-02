<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\ResponseTrait;
use Collator;

class CollaboratorController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        try {
            //select2


            $collaborator = Collaborator::query()->select([
                'id',
                'name',
            ]);

            if ($request->has('q')) {

                $collaborator->where('name', 'like', '%' . $request->get('q') . '%');
            }

            $data = $collaborator->get();

            $data->push(['id' => 0, 'name' => 'Nobody']);

            return $this->successResponse($data);
        } catch (\Throwable $th) {

            return $this->errorResponse();
        }
    }

    public function inforCollaboratorDetail($id)
    {
        try {
            $data = Collaborator::query()->select([
                'birthday',
                'phone_number',
                'address',
                'description',
                'name',
            ])->find($id);

            return $this->successResponse($data);
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }
}
