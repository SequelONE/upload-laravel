<?php

Route::group(['middleware' => 'web'], function () {

    if ( Config::get('app.env') !== 'production' ) {

        Route::get('/upload', '\Upload\UploadController@getExamplePage');

        Route::post('/upload', '\Upload\UploadController@postExamplePage');

        Route::get('/upload/example_source', '\Upload\UploadController@examplePageSource');
    }

    if ( \Upload\Util::isStorageHost() ) {

        Route::post(\Upload\ConfigMapper::get('route_preprocess'), '\Upload\UploadController@preprocess')->middleware(\Upload\ConfigMapper::get('middleware_preprocess'));

        Route::options(\Upload\ConfigMapper::get('route_preprocess'), '\Upload\UploadController@options');

        Route::post(\Upload\ConfigMapper::get('route_uploading'), '\Upload\UploadController@saveChunk')->middleware(\Upload\ConfigMapper::get('middleware_uploading'));

        Route::options(\Upload\ConfigMapper::get('route_uploading'), '\Upload\UploadController@options');

        Route::get(\Upload\ConfigMapper::get('route_display').'/{uri}', '\Upload\ResourceController@display')->middleware(\Upload\ConfigMapper::get('middleware_display'));

        Route::get(\Upload\ConfigMapper::get('route_download').'/{uri}/{newName}', '\Upload\ResourceController@download')->middleware(\Upload\ConfigMapper::get('middleware_download'));
    }

});