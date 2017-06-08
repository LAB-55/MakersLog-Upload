<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use Redirect;
use Storage;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Exception;

define('APPLICATION_NAME', 'Drive API PHP Quickstart');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
define('SCOPES', implode(' ', array(
  Google_Service_Drive::DRIVE_METADATA_READONLY)
));

class UploadController extends Controller
{
	public function create() {
		return view('home');
	}

	public function getClient() {
		$client = new Google_Client();
		$client->setApplicationName(APPLICATION_NAME);
		$client->setScopes(SCOPES);
		$client->setAuthConfig(CLIENT_SECRET_PATH);
		$client->setAccessType('offline');
		$authUrl = $client->createAuthUrl();
		$accessToken = env('GOOGLE_DRIVE_ACCESS_TOKEN');
		$refreshToken = env('GOOGLE_DRIVE_REFRESH_TOKEN');
		$client->setAccessToken($accessToken);
		$client->fetchAccessTokenWithRefreshToken($refreshToken);
		$client->getAccessToken();
		return $client;
	}

    public function upload (Request $request) {
    	$title = $request->title;
    	$file = Input::file('ppt');
		$extension = $file->extension();
		$filename = $title.'.'.$extension;
		//$filename = $file->getClientOriginalName();
		$file->move(public_path().'/ppt', $filename);
		
  	  	$content = file_get_contents(public_path().'/ppt/'.$filename);

    	$client = $this->getClient();
		$service = new Google_Service_Drive($client);

		$folderId = env('GOOGLE_DRIVE_FOLDER_ID');
		$fileMetadata = new Google_Service_Drive_DriveFile(array(
		  'name' => $filename,
		  'mimeType' => 'application/vnd.google-apps.presentation',
		  'parents' => array($folderId)
		));
		// dd($fileMetadata);
		$presentation = $service->files->create($fileMetadata, array(
		  'data' => $content,
		  'uploadType' => 'multipart',
		  'fields' => 'id')
		);
		$presentationid = $presentation->id;
        Session::flash("success","$presentationid Uploaded");
        return redirect('/');
    }
}
