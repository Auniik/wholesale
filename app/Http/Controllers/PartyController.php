<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:party-list')->only('index');
        $this->middleware('can:party-create')->only('store');
        $this->middleware('can:party-update')->only('update', 'edit');
        $this->middleware('can:party-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $parties = Party::where('company_id', company_id())->orderByDesc('id');

        if ($request->filled('party_name')){
            $parties->where('name', 'LIKE', "%{$request->party_name}%");
        }


        return view('crm.partyInfo.index', [
            'parties' => $parties->paginate(25),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('crm.partyInfo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        Party::create($request->all());
        return back()->withSuccess('Party added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function show(Party $party)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function edit(Party $party)
    {
        return view('crm.partyInfo.edit', compact('party'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Party $party)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $party->update($request->all());
        return back()->withSuccess('Party updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy(Party $party)
    {
        $party->delete();
        return back()->withSuccess('Party Deleted Successfully!');
    }


    public function load_parties(Request $request){
        $queryParam = $request->query('name');
        $parties = Party::query()
                        ->select('name', 'id')
                        ->where([['company_id', auth()->user()->fk_company_id],['status', 1]])
                        ->where('name', 'LIKE', "%{$queryParam}%")->get();
        return response()->json($parties);
    }

    public function getByName(Request $request)
    {
        return Party::where('name', 'like', "%$request->name%")->get();
    }
}
