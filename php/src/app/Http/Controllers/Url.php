<?php

namespace App\Http\Controllers;

use App\UrlActivities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Urls;
use Illuminate\Support\Facades\DB;

class Url extends Controller
{
    public function create( Request $request )
    {
        $data = $request->all();
        $validation = Validator::make(
            $request->all(),
            [
                'url' => 'required|url',
                'shortname' => 'sometimes|unique:urls,shortname|max:15'
            ]
        );

        if ( $validation->fails() ) {
            return response()->json( $validation->errors(), 400 );
        }

        try {
            $url = Urls::where( 'url', $data['url'] )->first();

            if ( ! $url ) {
                $url = new Urls();
                $url->fill( $data );

                if ( empty( $data['shortname'] ) ) {
                    $bytes =  random_bytes(15);
                    $url->fill( [ 'shortname' => bin2hex( $bytes ) ] );
                }

                $url->save();
            }
        } catch (\Throwable $th) {
            return response()->json( 'Error to create short url.', 500 );
        }

        UrlActivities::create( [ 'url_id' => $url['id'] ] );
        header( "Location: $data[url]" );

        return;
    }

    public function locate( string $slug )
    {
        $url = Urls::where('shortname', $slug)->first();

        if ( ! $url ) {
            return response()->json( 'not found', 404 );
        }

        UrlActivities::create( [ 'url_id' => $url['id'] ] );
        header( "Location: $url[url]" );

        return;
    }

    public function topUrls() {
        $topUrls = DB::table( 'urls' )
            ->select( 'urls.id', 'urls.title', 'urls.url', DB::raw( 'count( activities.id ) as count' ) )
            ->join( 'url_activities as activities', 'activities.url_id', 'urls.id' )
            ->orderBy( 'count' , 'desc' )
            ->groupBy( 'urls.id' )
            ->limit( 100 )
            ->get();

        return response()->json(
            $topUrls,
            $topUrls->count() > 0 ? 200 : 404
        );
    }
}
