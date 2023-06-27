<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\ResponseTrait;

class CollaboratorController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        try {
            $collaborator = Collaborator::all();
            $data = $collaborator->filter(function ($each) use ($request) {
                if ($request->has('q')) {
                    return Str::contains(strtolower($each->name), $request->get('q'));
                }
                return true;
            });
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
