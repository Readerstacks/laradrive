<?php
 
Route::group(['namespace' => 'Readerstacks\Drive\Http\controllers'], function(){
    
   
	//Filemanger

	Route::get('autocomplete-search-all-user-for-email/{role?}', 'FileManagerUserController@getAllUserForEmail')->name('file-manager.getAllUserForEmail');

	Route::get('/file-manager', 'FileManagerController@index')->name('filemanager.index');
	Route::post('/file-manager/init', 'FileManagerController@myFiles');
	Route::post('/file-manager/open', 'FileManagerController@myFiles');

	Route::post('/file-manager/create-folder', 'FileManagerController@createFolder');
	Route::post('/file-manager/create-file', 'FileManagerController@createFile');
	Route::post('/file-manager/delete', 'FileManagerController@deleteFileFolder');
	Route::post('/file-manager/trash-can', 'FileManagerController@trashCan');
	Route::post('/file-manager/paste', 'FileManagerController@pasteItems');
	Route::post('/file-manager/get-shareable-link', 'FileManagerController@getShareAbleLink');
	Route::post('/file-manager/share-file', 'FileManagerController@share');
	Route::get('/file-manager/shared/{link}', 'FileManagerController@getShareDetail');
	Route::get('/file-manager/test', 'FileManagerController@test');
	Route::post('/file-manager/rename', 'FileManagerController@rename');
	Route::post('/file-manager/restore', 'FileManagerController@restore');
	Route::post('/file-manager/get-shared-users', 'FileManagerController@getShareUsers');
	Route::post('/file-manager/remove-shared-users', 'FileManagerController@removeSharedPermission');
	Route::post('/file-manager/get-share-user-suggestions', 'FileManagerController@getUserSuggestions');
	
	Route::post('/file-manager-user/listings', 'FileManagerUserController@datatables')->name('file-manager-user.datatables');
	Route::get('/file-manager-user/delete/{slug}', 'FileManagerUserController@delete')->name('file-manager-user.delete');
	Route::get('/file-manager-user/edit/{slug}', 'FileManagerUserController@edit')->name('file-manager-user.edit');
	Route::resource('file-manager-user', 'FileManagerUserController');
  
});