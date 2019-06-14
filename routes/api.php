<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
|@author Dominique DAMBA (dominiquedamba@outlook.com)
|
*/


Route::get('agence', 'API\\AgenceController@index')->name('api.liste-agence');
Route::get('agence/{slug}', 'API\\AgenceController@show')->name('api.detail-agence');
Route::post('agence', 'API\\AgenceController@store')->name('api.creation-agence');
Route::put('agence/{slug}', 'API\\AgenceController@update')->name('api.mise-a-jours-agence');
Route::delete('agence/{slug}', 'API\\AgenceController@destroy')->name('api.suppression-agence');


Route::get('article', 'API\\ArticleController@index')->name('api.liste-article');
Route::get('article/{slug}', 'API\\ArticleController@show')->name('api.detail-article');
Route::post('article', 'API\\ArticleController@store')->name('api.creation-article');
Route::put('article/{slug}', 'API\\ArticleController@update')->name('api.mise-a-jours-article');
Route::delete('article/{slug}', 'API\\ArticleController@destroy')->name('api.suppression-article');


Route::get('annonce', 'API\\AnnonceController@index')->name('api.liste-annonce');
Route::get('annonce/{slug}', 'API\\AnnonceController@show')->name('api.detail-annonce');
Route::post('annonce', 'API\\AnnonceController@store')->name('api.creation-annonce');
Route::put('annonce/{slug}', 'API\\AnnonceController@update')->name('api.mise-a-jours-annonce');
Route::delete('annonce/{slug}', 'API\\AnnonceController@destroy')->name('api.suppression-annonce');


Route::get('billet', 'API\\BilletController@index')->name('api.liste-billet');
Route::get('billet/{slug}', 'API\\BilletController@show')->name('api.detail-billet');
Route::post('billet', 'API\\BilletController@store')->name('api.creation-billet');
Route::put('billet/{slug}', 'API\\BilletController@update')->name('api.mise-a-jours-billet');
Route::delete('billet/{slug}', 'API\\BilletController@destroy')->name('api.suppression-billet');


Route::get('categoriearticle', 'API\\CategorieArticleController@index')->name('api.liste-categoriearticle');
Route::get('categoriearticle/{slug}', 'API\\CategorieArticleController@show')->name('api.detail-categoriearticle');
Route::post('categoriearticle', 'API\\CategorieArticleController@store')->name('api.creation-categoriearticle');
Route::put('categoriearticle/{slug}', 'API\\CategorieArticleController@update')->name('api.mise-a-jours-categoriearticle');
Route::delete('categoriearticle/{slug}', 'API\\CategorieArticleController@destroy')->name('api.suppression-categoriearticle');

Route::get('classe', 'API\ClasseController@index')->name('api.liste-classe');
Route::get('classe/{slug}', 'API\ClasseController@show')->name('api.detail-classe');
Route::post('classe', 'API\ClasseController@store')->name('api.creation-classe');
Route::put('classe/{slug}', 'API\ClasseController@update')->name('api.mise-a-jours-classe');
Route::delete('classe/{slug}', 'API\ClasseController@destroy')->name('api.suppression-classe');

Route::get('commentaire', 'API\\CommentaireController@index')->name('api.liste-commentaire');
Route::get('commentaire/{slug}', 'API\\CommentaireController@show')->name('api.detail-commentaire');
Route::post('commentaire', 'API\\CommentaireController@store')->name('api.creation-commentaire');
Route::put('commentaire/{slug}', 'API\\CommentaireController@update')->name('api.mise-a-jours-commentaire');
Route::delete('commentaire/{slug}', 'API\\CommentaireController@destroy')->name('api.suppression-commentaire');

Route::get('image', 'API\\ImageController@index')->name('api.liste-image');
Route::get('image/{slug}', 'API\\ImageController@show')->name('api.detail-image');
Route::post('image', 'API\\ImageController@store')->name('api.creation-image');
Route::put('image/{slug}', 'API\\ImageController@update')->name('api.mise-a-jours-image');
Route::delete('image/{slug}', 'API\\ImageController@destroy')->name('api.suppression-image');

Route::get('itineraire', 'API\\ItineraireController@index')->name('api.liste-itineraire');
Route::get('itineraire/{slug}', 'API\\ItineraireController@show')->name('api.detail-itineraire');
Route::post('itineraire', 'API\\ItineraireController@store')->name('api.creation-itineraire');
Route::put('itineraire/{slug}', 'API\\ItineraireController@update')->name('api.mise-a-jours-itineraire');
Route::delete('itineraire/{slug}', 'API\\ItineraireController@destroy')->name('api.suppression-itineraire');

Route::get('location', 'API\\LocationController@index')->name('api.liste-location');
Route::get('location/{slug}', 'API\\LocationController@show')->name('api.detail-location');
Route::post('location', 'API\\LocationController@store')->name('api.creation-location');
Route::put('location/{slug}', 'API\\LocationController@update')->name('api.mise-a-jours-location');
Route::delete('location/{slug}', 'API\\LocationController@destroy')->name('api.suppression-location');

Route::get('modefacturation', 'API\\ModeFacturationController@index')->name('api.liste-modefacturation');
Route::get('modefacturation/{slug}', 'API\\ModeFacturationController@show')->name('api.detail-modefacturation');
Route::post('modefacturation', 'API\\ModeFacturationController@store')->name('api.creation-modefacturation');
Route::put('modefacturation/{slug}', 'API\\ModeFacturationController@update')->name('api.mise-a-jours-modefacturation');
Route::delete('modefacturation/{slug}', 'API\\ModeFacturationController@destroy')->name('api.suppression-modefacturation');

Route::get('note', 'API\\NoteController@index')->name('api.liste-note');
Route::get('note/{slug}', 'API\\NoteController@show')->name('api.detail-note');
Route::post('note', 'API\\NoteController@store')->name('api.creation-note');
Route::put('note/{slug}', 'API\\NoteController@update')->name('api.mise-a-jours-note');
Route::delete('note/{slug}', 'API\\NoteController@destroy')->name('api.suppression-note');

Route::get('notification', 'API\\NotificationController@index')->name('api.liste-notification');
Route::get('notification/{slug}', 'API\\NotificationController@show')->name('api.detail-notification');
Route::post('notification', 'API\\NotificationController@store')->name('api.creation-notification');
Route::put('notification/{slug}', 'API\\NotificationController@update')->name('api.mise-a-jours-notification');
Route::delete('notification/{slug}', 'API\\NotificationController@destroy')->name('api.suppression-notification');

Route::get('pays', 'API\\PaysController@index')->name('api.liste-pays');
Route::get('pays/{slug}', 'API\\PaysController@show')->name('api.detail-pays');
Route::post('pays', 'API\\PaysController@store')->name('api.creation-pays');
Route::put('pays/{slug}', 'API\\PaysController@update')->name('api.mise-a-jours-pays');
Route::delete('pays/{slug}', 'API\\PaysController@destroy')->name('api.suppression-pays');

Route::get('positionannonce', 'API\\PositionAnnonceController@index')->name('api.liste-positionannonce');
Route::get('positionannonce/{slug}', 'API\\PositionAnnonceController@show')->name('api.detail-positionannonce');
Route::post('positionannonce', 'API\\PositionAnnonceController@store')->name('api.creation-positionannonce');
Route::put('positionannonce/{slug}', 'API\\PositionAnnonceController@update')->name('api.mise-a-jours-positionannonce');
Route::delete('positionannonce/{slug}', 'API\\PositionAnnonceController@destroy')->name('api.suppression-positionannonce');


Route::get('reservationvoyage', 'API\\ReservationVoyageController@index')->name('api.liste-reservationvoyage');
Route::get('reservationvoyage/{slug}', 'API\\ReservationVoyageController@show')->name('api.detail-reservationvoyage');
Route::post('reservationvoyage', 'API\\ReservationVoyageController@store')->name('api.creation-reservationvoyage');
Route::put('reservationvoyage/{slug}', 'API\\ReservationVoyageController@update')->name('api.mise-a-jours-reservationvoyage');
Route::delete('reservationvoyage/{slug}', 'API\\ReservationVoyageController@destroy')->name('api.suppression-billet');

Route::get('reservationlocation', 'API\\ReservationLocationController@index')->name('api.liste-reservationlocation');
Route::get('reservationlocation/{slug}', 'API\\ReservationLocationController@show')->name('api.detail-reservationlocation');
Route::post('reservationlocation', 'API\\ReservationLocationController@store')->name('api.creation-reservationlocation');
Route::put('reservationlocation/{slug}', 'API\\ReservationLocationController@update')->name('api.mise-a-jours-reservationlocation');
Route::delete('reservationlocation/{slug}', 'API\\ReservationLocationController@destroy')->name('api.suppression-reservationlocation');

Route::get('decoupageun', 'API\\DecoupageUnController@index')->name('api.liste-decoupageun');
Route::get('decoupageun/{slug}', 'API\\DecoupageUnController@show')->name('api.detail-decoupageun');
Route::post('decoupageun', 'API\\DecoupageUnController@store')->name('api.creation-decoupageun');
Route::put('decoupageun/{slug}', 'API\\DecoupageUnController@update')->name('api.mise-a-jours-decoupageun');
Route::delete('decoupageun/{slug}', 'API\\DecoupageUnController@destroy')->name('api.suppression-decoupageun');

Route::get('decoupagedeux', 'API\\DecoupageDeuxController@index')->name('api.liste-decoupagedeux');
Route::get('decoupagedeux/{slug}', 'API\\DecoupageDeuxController@show')->name('api.detail-decoupagedeux');
Route::post('decoupagedeux', 'API\\DecoupageDeuxController@store')->name('api.creation-decoupagedeux');
Route::put('decoupagedeux/{slug}', 'API\\DecoupageDeuxController@update')->name('api.mise-a-jours-decoupagedeux');
Route::delete('decoupagedeux/{slug}', 'API\\DecoupageDeuxController@destroy')->name('api.suppression-decoupagedeux');

Route::get('decoupagetrois', 'API\\DecoupageTroisController@index')->name('api.liste-decoupagetrois');
Route::get('decoupagetrois/{slug}', 'API\\DecoupageTroisController@show')->name('api.detail-decoupagetrois');
Route::post('decoupagetrois', 'API\\DecoupageTroisController@store')->name('api.creation-decoupagetrois');
Route::put('decoupagetrois/{slug}', 'API\\DecoupageTroisController@update')->name('api.mise-a-jours-decoupagetrois');
Route::delete('decoupagetrois/{slug}', 'API\\DecoupageTroisController@destroy')->name('api.suppression-decoupagetrois');

Route::get('sitetouristique', 'API\\SiteTouristiqueController@index')->name('api.liste-sitetouristique');
Route::get('sitetouristique/{slug}', 'API\\SiteTouristiqueController@show')->name('api.detail-sitetouristique');
Route::post('sitetouristique', 'API\\SiteTouristiqueController@store')->name('api.creation-sitetouristique');
Route::put('sitetouristique/{slug}', 'API\\SiteTouristiqueController@update')->name('api.mise-a-jours-sitetouristique');
Route::delete('sitetouristique/{slug}', 'API\\SiteTouristiqueController@destroy')->name('api.suppression-sitetouristique');

Route::get('tarifannonce', 'API\\TarifAnnonceController@index')->name('api.liste-tarifannonce');
Route::get('tarifannonce/{slug}', 'API\\TarifAnnonceController@show')->name('api.detail-tarifannonce');
Route::post('tarifannonce', 'API\\TarifAnnonceController@store')->name('api.creation-tarifannonce');
Route::put('tarifannonce/{slug}', 'API\\TarifAnnonceController@update')->name('api.mise-a-jours-tarifannonce');
Route::delete('tarifannonce/{slug}', 'API\\TarifAnnonceController@destroy')->name('api.suppression-tarifannonce');

Route::get('transaction', 'API\\TransactionController@index')->name('api.liste-transaction');
Route::get('transaction/{slug}', 'API\\TransactionController@show')->name('api.detail-transaction');
Route::post('transaction', 'API\\TransactionController@store')->name('api.creation-transaction');
Route::put('transaction/{slug}', 'API\\TransactionController@update')->name('api.mise-a-jours-transaction');
Route::delete('transaction/{slug}', 'API\\TransactionController@destroy')->name('api.suppression-billet');

Route::get('typeannonce', 'API\\TypeAnnonceController@index')->name('api.liste-typeannonce');
Route::get('typeannonce/{slug}', 'API\\TypeAnnonceController@show')->name('api.detail-typeannonce');
Route::post('typeannonce', 'API\\TypeAnnonceController@store')->name('api.creation-typeannonce');
Route::put('typeannonce/{slug}', 'API\\TypeAnnonceController@update')->name('api.mise-a-jours-typeannonce');
Route::delete('typeannonce/{slug}', 'API\\TypeAnnonceController@destroy')->name('api.suppression-typeannonce');

Route::get('ville', 'API\\VilleController@index')->name('api.liste-ville');
Route::get('ville/{slug}', 'API\\VilleController@show')->name('api.detail-ville');
Route::post('ville', 'API\\VilleController@store')->name('api.creation-ville');
Route::put('ville/{slug}', 'API\\VilleController@update')->name('api.mise-a-jours-ville');
Route::delete('ville/{slug}', 'API\\VilleController@destroy')->name('api.suppression-ville');

Route::get('villeitineraire', 'API\\VilleItineraireController@index')->name('api.liste-villeitineraire');
Route::get('villeitineraire/{slug}', 'API\\VilleItineraireController@show')->name('api.detail-villeitineraire');
Route::post('villeitineraire', 'API\\VilleItineraireController@store')->name('api.creation-villeitineraire');
Route::put('villeitineraire/{slug}', 'API\\VilleItineraireController@update')->name('api.mise-a-jours-villeitineraire');
Route::delete('villeitineraire/{slug}', 'API\\VilleItineraireController@destroy')->name('api.suppression-villeitineraire');

Route::get('voyage', 'API\\VilleController@index')->name('api.liste-voyage');
Route::get('voyage/{slug}', 'API\\VilleController@show')->name('api.detail-voyage');
Route::post('voyage', 'API\\VilleController@store')->name('api.creation-voyage');
Route::put('voyage/{slug}', 'API\\VilleController@update')->name('api.mise-a-jours-voyage');
Route::delete('voyage/{slug}', 'API\\VilleController@destroy')->name('api.suppression-voyage');

Route::get('partenaire', 'API\\PartenaireController@index')->name('api.liste-partenaire');
Route::get('partenaire/{slug}', 'API\\PartenaireController@show')->name('api.detail-partenaire');
Route::post('partenaire', 'API\\PartenaireController@store')->name('api.creation-partenaire');
Route::put('partenaire/{slug}', 'API\\PartenaireController@update')->name('api.mise-a-jours-partenaire');
Route::delete('partenaire/{slug}', 'API\\PartenaireController@destroy')->name('api.suppression-partenaire');
Route::get('partenaire/activate/{slug}', 'API\\PartenaireController@activation')->name('compte.activation-partenaire');
Route::get('partenaire/desactivate/{slug}', 'API\\PartenaireController@deactivation')->name('compte.desactivation-partenaire');


Route::get('client/activate/{slug}', 'API\\ClientController@activation')->name('compte.activation-client');
Route::get('client/desactivate/{slug}', 'API\\ClientController@deactivation')->name('compte.desactivation-client');
Route::get('client', 'API\\ClientController@index')->name('api.liste-client');
Route::post('create/client', 'API\\ClientController@store')->name('api.creation-client');
Route::post('update-client', 'API\\InfoUpdateClientController@update')->name('api.mise-a-jours-client');
Route::delete('delete-client/{slug}', 'API\\ClientController@destroy')->name('api.suppression-client');


Route::get('admin/activate/{slug}', 'API\\AdminController@activation')->name('compte.activation-admin');
Route::get('admin/desactivate/{slug}', 'API\\AdminController@deactivation')->name('compte.desactivation-admin');
Route::get('admin', 'API\\AdminController@index')->name('api.liste-admin');
Route::post('create/admin', 'API\\AdminController@store')->name('api.creation-admin');
Route::post('update-admin', 'API\\InfoUpdateAdminController@update')->name('api.mise-a-jours-admin');
Route::delete('delete-admin/{slug}', 'API\\AdminController@destroy')->name('api.suppression-admin');


Route::get('personnel/activate/{slug}', 'API\\PersonnelController@activation')->name('compte.activation-personnel');
Route::get('personnel/desactivate/{slug}', 'API\\PersonnelController@deactivation')->name('compte.desactivation-personnel');
Route::post('create/personnel', 'API\\PersonnelController@store')->name('api.creation-personnel');
Route::post('update-personnel', 'API\\InfoUpdatePersonnelController@update')->name('api.mise-ajours-personnel');
Route::post('update-role/{slug}', 'API\\PersonnelController@changeRole')->name('api.mise-ajours-role');
Route::delete('delete-personnel/{slug}', 'API\\PersonnelController@destroy')->name('api.suppression-personnel');
Route::get('personnel', 'API\\PersonnelController@index')->name('api.liste-personnel');


// roles

Route::get('role-personnel', 'API\\RoleController@personnel')->name('api.role-personnel');


Route::post('reset-password', 'API\\PasswordResetController@reset')->name('api.mise-a-jours-mot-de-pass');


Route::apiResource('log', 'API\\LogController');


// Charger les villes d'un pays
Route::get('ville-pays/{pays}', 'API\\VilleController@pays_ville');

// retiurner une ville à partir de son ID
Route::get('ville_id/{id}', 'API\\VilleCOntroller@ville_id');


