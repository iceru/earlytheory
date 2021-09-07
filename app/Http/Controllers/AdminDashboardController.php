<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Analytics;
use Spatie\Analytics\Period;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalVisitors1 = Analytics::fetchTotalVisitorsAndPageViews(Period::months(1), 5);
        $totalVisitors3 = Analytics::fetchTotalVisitorsAndPageViews(Period::months(3));
        $totalVisitors7 = Analytics::fetchTotalVisitorsAndPageViews(Period::days(7));
        $mostVisited1 = Analytics::fetchMostVisitedPages(Period::days(30), 5);
        $mostVisited3 = Analytics::fetchMostVisitedPages(Period::months(3), 5);
        $mostVisited7 = Analytics::fetchMostVisitedPages(Period::days(7), 5);
        $fetchUser3 = Analytics::fetchUserTypes(Period::months(3));
        $fetchUser1 = Analytics::fetchUserTypes(Period::months(1));
        $fetchUser7 = Analytics::fetchUserTypes(Period::days(7));
        $topReferrers3 = Analytics::fetchTopReferrers(Period::months(3), 5);
        $topReferrers1 = Analytics::fetchTopReferrers(Period::months(1), 5);
        $topReferrers7 = Analytics::fetchTopReferrers(Period::days(7), 5);

        return view('admin.dashboard', compact('mostVisited1', 'mostVisited3', 'mostVisited7', 'fetchUser3', 'fetchUser1', 'fetchUser7', 'totalVisitors3',
        'totalVisitors1', 'totalVisitors7', 'topReferrers3', 'topReferrers1', 'topReferrers7'));
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
