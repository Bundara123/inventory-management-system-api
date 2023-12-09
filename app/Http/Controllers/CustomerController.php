<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Customers\StoreCustomerRequest;
use App\Http\Requests\Customers\UpdateCustomerRequest;
use Exception;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('query');
        $limit = $request->query('limit');
        $page = $request->query('page');
        $customers = Customer::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', "%$search%");
        })->latest()->paginate($limit, ['*'], 'page', $page);
        $data = [];
        $data['records']
            = $customers->items();
        $data['total'] =
            $customers->total();
        $data['page']
            = $customers->currentPage();
        $data['limit'] =
            $customers->perPage();
        $data['message'] = 'Resource retrieved successfully';
        return response()->json($data);
    }
    public function store(StoreCustomerRequest $request)
    {
        try {
            return response()->json($request->all());
            // The request is validated, and you can access the validated data using $request->validated()
            $customer = Customer::create($request->all());
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('customers/', $filename, 'public');
                $customer->update([
                    'photo' => $filename
                ]);
            }
            $data = [];
            $data['data'] = $customer;
            $data['message'] = 'Resource retrieved successfully';
            return response()->json($data);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        try {
            $customer = Customer::with(['quotations', 'orders'])->find($id);
            if (!$customer) {
                return response()->json(["data" => (object)[], "message" => "Not Found"], 404);
            }
            return response()->json(["data" => $customer], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function update(UpdateCustomerRequest $request, $id)
    {
        try {
            $customer = Customer::find($id);
            if (!$customer) {
                return response()->json(["data" => (object)[], "message" => "Not Found"], 404);
            }
            $customer->update($request->except('photo'));
            if ($request->hasFile('photo')) {
                if ($customer->photo) {
                    unlink(public_path('storage/customers/') . $customer->photo);
                }
                $file =  $request->file('photo');
                $fileName = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('customers/', $fileName, 'public');
                // Save DB
                $customer->update([
                    'photo' => $fileName
                ]);
            }
            return response()->json(["data" => $customer], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
    public function updateStatus(Request $request, $id)
    {
        try {
            $customer = Customer::find($id);
            if (!$customer) {
                return response()->json(["data" => (object)[], "message" => "Not Found"], 404);
            }
            $customer->update([
                'status' => $request->input('status')
            ]);
            return response()->json(["message" => "Customer has been deleted!"], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
    public function destroy($id)
    {
        try {
            $customer = Customer::find($id);
            if (!$customer) {
                return response()->json(["data" => (object)[], "message" => "Not Found"], 404);
            }
            $customer->update([
                'status' => 'deleted'
            ]);
            return response()->json(["message" => "Customer has been deleted!"], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
