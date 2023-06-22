<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRuleRequest;
use App\Http\Requests\UpdateRuleRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RuleController extends Controller
{
    public function index()
    {
        $rules = DB::table('permissions')->get();
        return view('admin.rules.index', compact('rules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRuleRequest $request)
    {
        Permission::create([
            'name' => $request->name,
        ]);

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $rule)
    {
        return view('admin.rules.edit', compact('rule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRuleRequest $request, Permission $rule)
    {
        $rule->update([
            'name' => $request->name,
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $rule)
    {
        $rule->delete();

        return redirect('admin/rules');
    }
}
