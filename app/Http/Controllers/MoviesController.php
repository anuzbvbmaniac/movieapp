<?php

namespace App\Http\Controllers;

use App\ViewModels\MoviesViewModel;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index() {

        // Popular Movie Data from API
        $popularMovies = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/popular')
            ->json()['results'];

        // Now Playing Movies Data from API
        $nowPlayingMovies = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/now_playing?append_to_response=videos,images')
            ->json()['results'];

        // Genre Data from API
        $genresArray = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/genre/movie/list')
            ->json()['genres'];

        // Adding Genre Data to collection
        $genres = collect($genresArray)->mapWithKeys( function ($genre) {
            return [$genre['id'] => $genre['name']];
        });

//        $viewModal = new MoviesViewModel(
//            $popularMovies,
//            $nowPlayingMovies,
//            $genres,
//        );

        return view('movies.index', [
            'nowPlayingMovies' => $nowPlayingMovies,
            'popularMovies' => $popularMovies,
            'genres' => $genres,
        ]);
    }

    public function create()
    {
        //
    }


    public function store(Request $request) {

    }


    public function show($id) {

        // Popular Movie Data from API
        $movie = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/'.$id.'?append_to_response=credits,videos,images')
            ->json();

        return view('movies.show', [
            'movie' => $movie,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return null;
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
        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return null;
    }
}
