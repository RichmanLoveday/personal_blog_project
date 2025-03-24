<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAuthorRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Author extends Controller
{
    public function index()
    {
        $allAuthors = User::where('role', 'author')
            ->latest()
            ->paginate(2)
            ->withQueryString();

        //  dd($allAuthors);
        return view('admin.author.index', compact('allAuthors'));
    }


    public function viewAuthorDetails(string|int $id)
    {
        $author = User::findOrFail($id);
        return view('admin.author.profile', compact('author'));
    }


    public function createAuthor()
    {
        return view('admin.author.create');
    }

    public function storeAuthor(CreateAuthorRequest $request)
    {
        // dd($request);
        $addNewAuthor = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'status' => 'active',
            'password' => Hash::make($request->password),
        ]);

        if (!$addNewAuthor) {
            return redirect()->back()->with('status', 'An error occured while adding new author');
        }

        return redirect()->route('admin.all.author')->with('status', 'Author added successfully');
    }


    public function statusUpdate(string|int $id, string $status)
    {
        // echo $status;
        // die;
        try {
            //? find user of fail
            $user = User::findOrFail($id);

            //? check if status params was right fully sent
            $expectedStatus = ['active', 'in-active'];

            if (!in_array($status, $expectedStatus)) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Expected 'active' or 'in-active', given '{$status}'"
                ], 400);
            }


            //? Update user status
            $user->where('id', $id)->update([
                'status' => $status,
                'updated_at' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Status updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occured on the server'
            ], 500);
        }
    }


    public function deleteAuthor(string|int $id)
    {
        try {
            //? find user of fail
            $user = User::findOrFail($id);
            $user->where('id', $id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Status updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occured on the server'
            ], 500);
        }
    }

    public function filterByDate(Request $request)
    {
        // dd($request);
        try {
            $endDate = now();
            $query = User::where('role', 'author');

            //? Check if a start date is provided
            if ($request->has('startDate') && !empty($request->startDate)) {
                $startDate = Carbon::createFromFormat('d-m-Y', $request->startDate)->startOfDay();
                $query->where('created_at', '>=', $startDate);
            }

            //? Check if an end date is provided
            if ($request->has('endDate') && !empty($request->endDate)) {
                $endDate = Carbon::createFromFormat('d-m-Y', $request->endDate)->endOfDay();
                $query->where('created_at', '<=', $endDate);
            }

            //? Get authors (latest first, max 20 unless a date filter is applied)
            $allAuthors = $query->latest()
                ->paginate(3)
                ->withQueryString();

            return view('admin.author.index', compact('allAuthors'));
        } catch (\Exception $e) {
            return back()->with('error', 'Invalid parameter formats: ' . $e->getMessage());
        }
    }

    public function editAuthor() {}

    public function updateAuthor() {}
}